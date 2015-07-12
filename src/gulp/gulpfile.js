
var gulp         = require('gulp');
var sass         = require('gulp-ruby-sass');
var minifycss    = require('gulp-minify-css');
var rename       = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
//var uglify     = require('gulp-uglify');
var argv         = require('yargs').argv;

var OPTIONS = null;

var blogBuildParams = {
	sassFolder :  '../scss/blog/',
	cssFolder : '../../dist/css',
	cssBaseName : 'blog'
};

var adminBuildParams = {
	sassFolder :  '../scss/admin/',
	cssFolder : '../../dist/admin/css',
	cssBaseName : 'admin'
};

gulp.task('styles',function()
{
	return sass(OPTIONS.sassFolder, { style: 'compressed' })
		.pipe(autoprefixer('last 2 version'))
		.pipe(rename({basename : OPTIONS.cssBaseName, suffix: '.min'}))
		.pipe(gulp.dest(OPTIONS.cssFolder));

		/* don't care about minification as this is a cordova project */
		// .pipe(rename({suffix: '.min'}))
		//.pipe(minifycss())
		//.pipe(gulp.dest('css'));
});


// gulp.task('scripts',function()
// {
// 	return gulp.src('../www/js/*.js')
// 		.pipe(rename({suffix: '.min'}))
// 		.pipe(uglify())
// 		.pipe(gulp.dest('../www/js'));
// });

gulp.task('watch',function()
{
	/* watch for changes to src files */
	gulp.watch('../scss/**', ['styles']);
	//gulp.watch('src/js/*.js', ['scripts']);

	/* notify live reload when files in web folder change*/
	//gulp.watch('web/js/*.js', notifyLiveReload);
	//gulp.watch('../*.html', notifyLiveReload);
  	//gulp.watch('../www/css/*.css', notifyLiveReload);
});

// gulp.task('serve', function()
// {
//   var express = require('express');
//   var app = express();
//   app.use(require('connect-livereload')({port : 35729}));
//   app.use(express.static(__dirname + '/../www'));
//   app.listen(9000);

//   console.log('local server listening on port 9000');
// });

/*
	@description:
	enables livereloading of pages when files change
	(requires livereload browser extension)
*/
// var tinylr;
// gulp.task('livereload', function()
// {
//   tinylr = require('tiny-lr')();
//   tinylr.listen(35729);
// });

// function notifyLiveReload(event)
// {
//   var fileName = require('path').relative(__dirname, event.path);

//   tinylr.changed({
//     body: {
//       files: [fileName]
//     }
//   });
// }

/*
	@description:
	default task, executes when you run gulp on the command line
	without any parameters
*/

//checks for command-line arguments
//builds correct files
//eg. --blog will build the blog css
gulp.task('init', function()
{
	if(argv.admin) OPTIONS = adminBuildParams;
	else OPTIONS          = blogBuildParams;
});

//gulp.task('default',['styles','serve','livereload','watch'],function(){});
gulp.task('default',['init', 'styles','watch'],function(){});
