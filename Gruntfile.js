/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	grunt.initConfig({

		// Generate POT files.
		makepot: {
			wpjmsq: {
				options: {
					domainPath: '/languages',
					exclude: [
						'assets',
						'node_modules'
					],
					mainFile:    'screening-questions-for-wp-job-manager.php',
					potFilename: 'screening-questions-for-wp-job-manager.pot'
				}
			}
		},

		// Minify CSS
		cssmin: {
			minify: {
				src: 'assets/css/wp-job-manager-screening-questions.css',
				dest: 'assets/css/wp-job-manager-screening-questions.min.css',
			}
		},

		// Minify JS
		uglify: {
			minify: {
				src: 'assets/js/wp-job-manager-screening-questions.js',
				dest: 'assets/js/wp-job-manager-screening-questions.min.js',
			}
		},

		// Generate README.md
		wp_readme_to_markdown: {
			wpjmsq: {
				files: {
					'README.md': 'readme.txt'
				},
			},
		},

	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );

	// Just an alias for pot file generation
	grunt.registerTask( 'pot', [
		'makepot'
	]);

	// Just an alias to minify css file
	grunt.registerTask( 'minifycss', [
		'cssmin'
	]);

	// Just an alias to minify js file
	grunt.registerTask( 'minifyjs', [
		'uglify'
	]);

	// Just an alias to generate README.md file
	grunt.registerTask( 'generatereadme', [
		'wp_readme_to_markdown'
	]);

};
