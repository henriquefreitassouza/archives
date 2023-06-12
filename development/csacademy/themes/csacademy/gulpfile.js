var gulp = require('gulp');
var scss = require('gulp-sass');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');
var cssnano = require('gulp-cssnano');
var merge = require('merge2');
var imagemin = require('gulp-imagemin');

var directories = {
  src: './src/',
  dist: './dist/',
  node: './node_modules/'
};

gulp.task('build-skeleton', function() {
  return gulp.src([
    directories.src + '**/*.php',
    directories.src + '**/*.pot',
    directories.src + '**/*.txt',
    directories.src + 'screenshot.png'
  ])
  .pipe(gulp.dest(directories.dist));
});

gulp.task('setup-vendor-scripts', function() {
  return gulp.src([
    directories.node + 'jquery/dist/jquery.min.js',
    directories.node + 'foundation-sites/dist/js/foundation.min.js'
  ])
  .pipe(gulp.dest(directories.src + 'assets/js'));
});

gulp.task('build-scripts', ['setup-vendor-scripts'], function() {
  return gulp.src([
    directories.src + 'assets/js/foundation.min.js',
    directories.src + 'js/navigation.js',
    directories.src + 'js/skip-link-focus-fix.js'
  ])
  .pipe(concat('scripts.min.js'))
  .pipe(uglify())
  .pipe(gulp.dest(directories.dist + 'assets/js'));
});

gulp.task('build-jquery-script', ['setup-vendor-scripts'], function() {
  return gulp.src([
    directories.src + 'assets/js/jquery.min.js'
  ])
  .pipe(uglify())
  .pipe(gulp.dest(directories.dist + 'assets/js'));
});

gulp.task('build-customizer-script', ['setup-vendor-scripts'], function() {
  return gulp.src([
    directories.src + 'js/customizer.js'
  ])
  .pipe(uglify())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'assets/js'));
});

gulp.task('setup-vendor-styles', function() {
  return gulp.src([
    directories.node + 'foundation-sites/scss/settings/_settings.scss',
    directories.src + 'sass/modules/_accessibility.scss'
  ])
  .pipe(gulp.dest(directories.src + 'assets/scss'));
});

gulp.task('build-styles', function() {
  return gulp.src([
    directories.src + 'assets/scss/csacademy.scss'
  ])
  .pipe(scss({outputStyle: 'compressed', includePaths: [directories.node + 'foundation-sites/scss']}).on('error', scss.logError))
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(rename('style.css'))
  .pipe(gulp.dest(directories.dist));
});

gulp.task('compress-images', function() {
  return gulp.src([
    directories.src + 'assets/images/*'
  ])
  .pipe(imagemin())
  .pipe(gulp.dest(directories.dist + 'assets/images'));
});

gulp.task('setup-development-environment', ['build-skeleton', 'setup-vendor-scripts', 'build-scripts', 'build-jquery-script', 'build-customizer-script', 'build-styles', 'compress-images']);

/* Development only */

gulp.task('setup-stage-environment', ['setup-development-environment'], function() {
  return gulp.src([
    directories.dist + '**/*'
  ])
  .pipe(gulp.dest('/opt/lampp/htdocs/csacademy_v2/wp-content/themes/csacademy'));
})

gulp.task('default', ['setup-stage-environment']);
