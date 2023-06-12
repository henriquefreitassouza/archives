var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var merge = require('merge2');
var imagemin = require('gulp-imagemin');
var sass = require('gulp-sass');
var cssnano = require('gulp-cssnano');
var autoprefixer = require('gulp-autoprefixer');

var directories = {
  src: './src/',
  dist: './dist/',
  node: './node_modules/'
};

gulp.task('build-skeleton', function() {
  return gulp.src([
    directories.src + '**/*.php',
    directories.src + '**/*.pot',
    directories.src + '**/*.txt'
  ])
  .pipe(gulp.dest(directories.dist));
});

gulp.task('build-scripts', function() {
  var admin_scripts = gulp.src([
    directories.src + 'admin/js/*.js'
  ])
  .pipe(concat('csacademy-admin.min.js'))
  .pipe(uglify())
  .pipe(gulp.dest(directories.dist + 'admin/js'));

  var public_scripts = gulp.src([
    directories.src + 'public/js/*.js'
  ])
  .pipe(concat('csacademy-public.min.js'))
  .pipe(uglify())
  .pipe(gulp.dest(directories.dist + 'public/js'));

  return merge(admin_scripts, public_scripts);
});

gulp.task('build-styles', function() {
  var admin_styles = gulp.src([
    directories.src + 'admin/scss/*.scss'
  ])
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'admin/css'));

  var public_styles = gulp.src([
    directories.src + 'public/scss/*.scss'
  ])
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest(directories.dist + 'public/css'));

  return merge(admin_styles, public_styles);
});

gulp.task('setup-development-environment', ['build-skeleton', 'build-scripts', 'build-styles']);
gulp.task('setup-stage-environment', ['setup-development-environment'], function() {
  return gulp.src([
    directories.dist + '**/*'
  ])
  .pipe(gulp.dest('/opt/lampp/htdocs/csacademy_v2/wp-content/plugins/csacademy'));
});

gulp.task('default', ['setup-stage-environment']);
