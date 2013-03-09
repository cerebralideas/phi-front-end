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
			files: ['grunt.js','src/ui-ix/core/*.js', 'src/ui-ix/extensions/**/*.js', 'src/app/**/*.js', 'test/**/*.js']
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
			files: ['<config:lint.files>', 'src/ui-ix/*.scss', 'src/ui-ix/core/**/*.scss', 'src/ui-ix/extensions/**/*.scss'],
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
		server: {
			base: 'http://phi.site'
		},
		reload: {
			port: 80,
			proxy: {
				port: 80,
				host: 'phi.site'
			}
		},
		uglify: {},
		replace: {
			srcToDist: {
				src: 'index.html',
				overwrite: true,
				replacements: [{
					from: '/src',
					to: '/dist'
				}]
			}
		},
		compass: {
			dev: {
				src: 'src/ui-ix/',
				dest: 'src/ui-ix/compiled',
				linecomments: true,
				forcecompile: true,
				require: []
			},
			prod: {
				src: 'src/',
				dest: 'dist/',
				outputstyle: 'compressed',
				linecomments: false,
				forcecompile: true,
				require: []
			}
		}
	});

	// Replaces strings for potential builds
	// grunt.loadNpmTasks('grunt-text-replace');

	// Run Grunt Reload
	grunt.loadNpmTasks('grunt-reload');

	// Run Sass conversion
	grunt.loadNpmTasks('grunt-compass');

	// Default task.
	grunt.registerTask('default', 'compass:dev');

	// Build task.
	grunt.registerTask('build', 'lint concat min compass-clean compass:prod');

};
