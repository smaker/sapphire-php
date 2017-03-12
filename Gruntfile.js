"use strict";

module.exports = function(grunt) {
	

	grunt.file.defaultEncoding = 'utf8';
	grunt.initConfig({
		phpdocumentor: {
			options: {
				command : 'run'
			},
			dist: {
				options: {
					directory: [
						'./_core/_install/',
						'./_core/_packages/',
						'./_core/Libraries/',
						'./common/',
						'./modules/',
						'./plugins/',
						'./themes/',
						
					],
					target: 'docs'
				}
			}
		},
		phplint: {
			options: {
				phpCmd: 'php'
			},
			src: [
				'**/*.php',
				'!_core/_cache/**',
				'!files/**',
				'!node_modules/**',
				'!vendor/**'
			]
		}
	});

	grunt.loadNpmTasks('grunt-phpdocumentor');
	grunt.loadNpmTasks('grunt-phplint');

	grunt.registerTask('phpdoc', [ 'phpdocumentor' ]);
	grunt.registerTask('lint', [ 'phplint' ]);
	grunt.registerTask('default', [ 'phpdocumentor', 'lint' ]);
};