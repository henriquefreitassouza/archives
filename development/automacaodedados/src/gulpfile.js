const gulp = require('gulp');
const postcss = require('gulp-postcss');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

const fs = require('fs');
const glob = require('glob');
const matter = require('gray-matter');
const rm_markdown = require('remove-markdown');
const lunr = require('lunr');

const languages = ['pt', 'en'];
const directories = {
  js: {
    src: 'assets/js/**/*.js',
    dest: 'static/js/'
  },
  css: {
    src: 'assets/css/**/*.css',
    dest: 'static/css/'
  },
  content: {
    pt: {
      src: 'content/stories/**/index.pt.md',
      dest: 'static/search-index.pt.json'
    },
    en: {
      src: 'content/stories/**/index.en.md',
      dest: 'static/search-index.en.json'
    }
  }
};

function compile_css(callback) {
  gulp.src([
    directories.css.src
  ])
  .pipe(postcss())
  .pipe(rename((path) => {
    path.extname = '.min.css'
  }))
  .pipe(gulp.dest(directories.css.dest));
  callback();
}

function compile_js(callback) {
  gulp.src([
    directories.js.src
  ])
  .pipe(uglify())
  .pipe(rename((path) => {
    path.extname = '.min.js'
  }))
  .pipe(gulp.dest(directories.js.dest));
  callback();
}

function get_corpus(lang) {
  let files = glob.sync(directories.content[lang].src);
  let corpus = [];
  for (let file of files) {
    if (!fs.lstatSync(file).isDirectory()) {
      if (file.indexOf('_index.md') != -1) continue;

      let meta = matter.read(file);

      if (meta.data.draft) continue;

      let author = (meta.data.author) ? meta.data.author : 'automacaodedados';
      author = JSON.parse(fs.readFileSync('data/authors/' + author + '.json'))['name'];

      let permalink = (meta.data.slug) ? meta.data.slug : file.replace(/.*\/stories\/(.*\/)index.*\.md/,'$1');
      if (!permalink.match(/\/$/)) permalink = permalink.replace(/(.)$/,'$1/');

      let thumbnail = 'content/stories/' + permalink + 'images/thumbnail.jpg';
      let thumbnail_exists = false;

      try {
        fs.accessSync(thumbnail, fs.constants.F_OK);
        thumbnail_exists = true;
      } catch (err) {}

      corpus.push({
        title: meta.data.title,
        author: author,
        publishdate: (meta.data.publishDate) ? new Date(meta.data.publishDate) : new Date(fs.lstatSync(file).birthtime),
        categories: (meta.data.categories) ? meta.data.categories[0].toLowerCase() : '',
        permalink: permalink,
        summary: meta.data.summary,
        thumbnail_exists: thumbnail_exists,
        content: rm_markdown(meta.content)
      });
    }
  }

  corpus = corpus.sort((a, b) => b.publishdate - a.publishdate);
  return corpus;
}

function create_index(callback) {
  for (let lang of languages) {
    let corpus = get_corpus(lang);
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
          thumbnail_exists: page.thumbnail_exists,
          permalink: page.permalink
        }
      }, this);
    });

    fs.writeFileSync(directories.content[lang].dest, JSON.stringify({ index: idx, corpus: searchable }), 'utf-8');
  }

  callback();
}

exports.compile_css = compile_css;
exports.compile_js = compile_js;
exports.compile_index = create_index;
exports.default = (callback) => {
  gulp.parallel(compile_css, compile_js, create_index);
  gulp.watch([directories.css.src], compile_css);
  gulp.watch([directories.js.src], compile_js);
  gulp.watch([directories.content.pt.src, directories.content.en.src], create_index);

  callback();
};
