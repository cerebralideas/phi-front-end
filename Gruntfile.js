/*global module:false*/
module.exports = function(grunt) {

	"use strict";

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),
		lint: {
			files: [
				'grunt.js','ui-ix/core/*.js',
				'ui-ix/extensions/**/*.js',
				'app/**/*.js'
			]
		},
		concat: {
			dist: {
				src: '',
				dest: ''
			}
		},
		min: {
			dist: {
				src: '',
				dest: ''
			}
		},
		watch: {
			files: [
				'<config:lint.files>',
				'ui-ix/*.scss',
				'ui-ix/core/**/*.scss',
				'ui-ix/extensions/**/*.scss',
				'ui-ix/prototype/*.scss'
			],
			tasks: 'default'
		},
		jshint: {
			options: {
				curly: true,
				eqeqeq: true,
				immed: true,
				latedef: true,
				newcap: true,
				noarg: true,
				sub: true,
				undef: true,
				boss: true,
				eqnull: true,
				browser: true
			},
			globals: {
				jQuery: true,
				angular: true,
				PHI: true
			}
		},
		uglify: {},
		compass: {
			dev: {
				options: {
					sassDir: 'ui-ix/',
					cssDir: 'demo-css/'
				}
			}
		},
		macreload: {
			reload: {
				browser: 'canary'
			}
		}
	});

	// Load in contrib task suite
	grunt.loadNpmTasks('grunt-contrib');

	// Load in Markdown task
	grunt.loadNpmTasks('grunt-markdown');

	// A Live Reload alternative
	grunt.loadNpmTasks('grunt-macreload');

	// Default task.
	grunt.registerTask('default', ['compass:dev', 'macreload']);
};
