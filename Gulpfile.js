var gulp = require( 'gulp'),
	plumber = require( 'gulp-plumber' ),
	uglify = require( 'gulp-uglify' );

var plumber_config = {
	errorHandler: function (err) {
		console.log(err.toString());
		this.emit('end');
	}
};

/*
JS
 */
gulp.task( 'js', function(){
	return gulp.src( 'src_js/**/*.js', { base: 'src_js' } )
		.pipe( plumber( plumber_config ) )
		.pipe( uglify() )
		.pipe( gulp.dest( 'assets' ) );
} );

/*
Tasks
 */
gulp.task( 'default', [ 'js' ] );