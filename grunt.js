/*global module:false*/
module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: '<json:package.json>',
		meta: {
			// This writes the comment that goes at the top of concatenated or minified project files.
			banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
					'<%= grunt.template.today("yyyy-mm-dd") %>\n' +
					'<%= pkg.homepage ? "* " + pkg.homepage + "\n" : "" %>' +
					'* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
					' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */'
		},
		lint: {
			files: [
				'grunt.js','ui-ix/core/*.js', 'ui-ix/extensions/**/*.js', 'app/**/*.js', '../test/**/*.js'
			]
		},
		qunit: {
			files: []
		},
		concat: {
			dist: {
				src: ['<banner:meta.banner>', '<file_strip_banner:src/<%= pkg.name %>.js>'],
				dest: 'dist/<%= pkg.name %>.js'
			}
		},
		min: {
			dist: {
				src: ['<banner:meta.banner>', '<config:concat.dist.dest>'],
				dest: 'dist/<%= pkg.name %>.min.js'
			}
		},
		watch: {
			files: [
				'<config:lint.files>', 'ui-ix/*.scss', 'ui-ix/core/**/*.scss', 'ui-ix/extensions/**/*.scss', 'ui-ix/prototype/*.scss'
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
				angular: true
			}
		},
		uglify: {},
		compass: {
			dev: {
				src: 'ui-ix/',
				dest: 'demo-css/',
				linecomments: true,
				forcecompile: true,
				require: []
			}
		},
		macreload: {
			reload: {
				browser: 'canary'
			}
		}
	});

	// Replaces strings for potential builds
	// grunt.loadNpmTasks('grunt-text-replace');

	// Live Reload
	grunt.loadNpmTasks('grunt-macreload');

	// Run Sass conversion
	grunt.loadNpmTasks('grunt-compass');

	// Default task.
	grunt.registerTask('default', 'compass:dev macreload');

	// Build task.
	grunt.registerTask('build', 'lint concat min compass-clean compass:prod macreload');
};
