const gulp = require('gulp');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

sass.compiler = require('node-sass');

const paths = {
  theme: {
    home: {
      src: 'src/',
      dist: 'dist/'
    },
    styles: {
      src: 'src/public/scss/**/*',
      dest: 'dist/public/css/'
    },
    scripts: {
      src: 'src/public/js/**/*.js',
      dest: 'dist/public/js/'
    }
  }
};

let compileStyles = () => {
  return gulp.src([
    paths.theme.styles.src
  ])
  .pipe(sass())
  .pipe(postcss([
    require('autoprefixer'),
    require('cssnano')
  ]))
  .pipe(gulp.dest(paths.theme.styles.dest));
}

let compileScripts = () => {
  return gulp.src(
    [paths.theme.scripts.src]
  )
  .pipe(babel({
    presets: ['@babel/env']
  }))
  .pipe(uglify())
  .pipe(gulp.dest(paths.theme.scripts.dest));
}

let buildTheme = () => {
  return gulp.src([
    paths.theme.home.src + '**/*',
    '!' + paths.theme.home.src + 'public/scss/**',
    '!' + paths.theme.home.src + 'public/js/**'
  ])
  .pipe(gulp.dest(paths.theme.home.dist));
}

let setStaging = () => {
  return gulp.src([
    paths.theme.home.dist + '**/*'
  ])
  .pipe(gulp.dest('../../../grav/user/themes/dash'))
}

exports.buildTheme = buildTheme;
exports.compileStyles = compileStyles;
exports.compileScripts = compileScripts;
exports.setStaging = setStaging;

exports.default = () => {
  gulp.watch(paths.theme.home.src + '**/*', gulp.series(buildTheme, gulp.parallel(compileStyles, compileScripts), setStaging));
}
