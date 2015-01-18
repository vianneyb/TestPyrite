// Include Gulp
var gulp = require('gulp');
 // Include plugins
var plugins = require("gulp-load-plugins")({
  pattern: ['gulp-*', 'gulp.*', 'main-bower-files'],
  replaceString: /\bgulp[\-.]/
});
var sync = require('gulp-config-sync');
var env = require('./package.json')

var dest = './public/vendor/';


gulp.task('fonts', function () {
  gulp.src('src/browser/bower_components/bootstrap/fonts/*')
    .pipe(plugins.rename(function (path) {
                path.basename += '-' + env.version;
            }))
    .pipe(gulp.dest(dest+'fonts/'));
});

gulp.task('less', function () {
  gulp.src('src/browser/stylesheets/main.less')
    .pipe(plugins.less({
      compress: false,cleancss: true
    }))
    .pipe(plugins.rename(function (path) {
                path.basename += '-' + env.version;
            }))
    .pipe(gulp.dest(dest+'css/'));
});


gulp.task('js', function() {
  var jsFiles = ['src/browser/javascripts/*'];
  gulp.src(plugins.mainBowerFiles().concat(jsFiles))
    .pipe(plugins.filter('*.js'))
    .pipe(plugins.concat('main.js'))
    .pipe(plugins.uglify())
    .pipe(plugins.rename(function (path) {
                path.basename += '-' + env.version;
            }))
    .pipe(gulp.dest(dest + 'js'));
 });

gulp.task('clean', function() {
    return gulp.src( dest, {read: false})
        .pipe(plugins.clean({force: true}));
});

gulp.task('sync', function() {
  gulp.src(['bower.json', 'composer.json'])
    .pipe(sync())
    .pipe(gulp.dest('.')); // write it to the same dir
});


gulp.task('inject',function(){

  var sources = gulp.src(['vendor/js/*.js', 'vendor/css/*.css'], {read: false,cwd: './public/'});
  gulp.src("./src/browser/layouts/*.twig")
  .pipe(plugins.inject(sources))
  .pipe(gulp.dest('./src/browser/layouts'));

})


gulp.task('build', ['sync','fonts', 'less', 'js','inject']);


gulp.task('watch', ['less', 'js'] ,function () {
  gulp.watch('src/browser/javascripts/**/*.js', [ 'js' ]);
  gulp.watch('src/browser/javascripts/*.js', [ 'js' ]);
  gulp.watch('src/browser/stylesheets/**/*.less', [ 'less' ]);
  gulp.watch('src/browser/stylesheets/*.less', [ 'less' ]);
});