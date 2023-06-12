const fs = require('fs');
const fm = require('gray-matter');
const lunr = require('lunr');
const languages = ['pt', 'en'];

module.exports = (grunt) => {
  grunt.initConfig({
    postcss: {
      options: {
        processors: [
          require('tailwindcss')(),
          require('autoprefixer')()
        ]
      },
      dist: {
        expand: true,
        cwd: '.',
        src: ['/src/assets/css/**/*.css'],
        dest: '/src/static/css/',
        ext: '.min.css'
      }
    },
    uglify: {
      files: [{
        expand: true,
        src: ['**/*.js', '!**/*.min.js'],
        dest: ['/src/static/js'],
        cwd: '/src/assets/js',
        rename: (dest, src) => {
          return dest + '/' + src.replace('.js', '.min.js');
        }
      }]
    },
    watch: {
      postcss: {
        files: ['/src/assets/css/**/*.css'],
        tasks: ['compile-css']
      },
      js: {
        files: ['/src/assets/js/**/*.js'],
        tasks: ['compile-js']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-postcss');

  let buildCorpus = (directory) => {
    let corpus = [];

    if (grunt.file.expand(directory).length == 0) {
      grunt.log.writeln('Directory not found. Search index was not generated. Verify the content path given and try again.');
      return;
    }

    grunt.file.recurse(directory, function(abspath, rootdir, subdir, filename) {
      if (filename == '_index.md') return;

      let page = fm(grunt.file.read(abspath, filename));

      if (page.data.draft) return;
      else {
        let author = (page.data.author) ? page.data.author : 'automacaodedados';
        if (grunt.file.expand('data/authors/' + author + '.json').length > 0) author = grunt.file.readJSON('data/authors/' + author + '.json')['name'];

        let publishdate = (page.data.publishdate) ? new Date(page.data.publishdate) : new Date(fs.statSync(abspath).birthtime);

        corpus.push({
          title: page.data.title,
          author: author,
          publishdate: publishdate,
          categories: (page.data.categories) ? page.data.categories[0].toLowerCase() : '',
          permalink: (page.data.slug) ? page.data.slug : subdir,
          summary: page.data.summary,
          content: page.content
        });
      }
    });

    corpus = corpus.sort((a, b) => b.publishdate - a.publishdate);
    return corpus;
  }

  let buildIdx = (corpus) => {
    let searchable = {};
    let idx = lunr(function() {
      this.field('title');
      this.field('categories');
      this.field('summary');
      this.field('content');
      this.ref('permalink');

      corpus.forEach((page) => {
        this.add(page);
        searchable[page.permalink] = {
          title: page.title,
          summary: page.summary,
          author: page.author,
          categories: page.categories,
          publishdate: page.publishdate,
          permalink: page.permalink
        };
      }, this);
    });

    return {
      idx: idx,
      searchable: searchable
    };
  }

  grunt.registerTask('build-corpus', () => {
    for (const lang of languages) {
      let content_directory = 'content/' + lang + '/stories';
      let idx_name = 'search-index.' + lang + '.json';
      let corpus = buildCorpus(content_directory);

      if (corpus.length == 0) {
        grunt.fail.fatal('Zero indexes.');
      }

      let searchable = buildIdx(corpus);

      if (Object.keys(searchable.searchable).length == 0) {
        grunt.fail.fatal('Corpus not indexed.');
      }

      grunt.file.write('static/' + idx_name, JSON.stringify({ index: searchable.idx, corpus: searchable.searchable }));
      grunt.log.writeln('Index ' + idx_name + ' generated at /static');
    }
  });

  grunt.registerTask('compile-css', ['postcss']);
  grunt.registerTask('compile-js', ['uglify']);
  grunt.registerTask('default', ['compile-css', 'compile-js', 'build-corpus']);
}
