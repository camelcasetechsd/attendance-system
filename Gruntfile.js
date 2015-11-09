module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        dirs: {
            jsSrc: 'public/js',
            cssSrc: 'public/css',
            bowerSrc: 'public/bower_components',
            dest: 'public/concat'
        },
        concat: {
            options: {
                separator: '\n',
                process: function (src, filepath) {
                    return '/* OriginalFileName : ' + filepath + ' */ \n\n' + src;
                }
            },
            js: {
                options: {
                    separator: ';\n',
                },
                nonull: true,
                dest: '<%= dirs.dest %>/app.js',
                src: [
                    '<%= dirs.bowerSrc %>/jquery/dist/jquery.js',
                    '<%= dirs.bowerSrc %>/bootstrap/dist/js/bootstrap.js',
                    '<%= dirs.bowerSrc %>/metisMenu/dist/metisMenu.js',
                    '<%= dirs.bowerSrc %>/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js',
                    '<%= dirs.jsSrc %>/confirmation.js',
                    '<%= dirs.jsSrc %>/ajaxCalls.js',
                    '<%= dirs.jsSrc %>/general.js',
                    '<%= dirs.jsSrc %>/moment.js',
                    '<%= dirs.jsSrc %>/deactivated.js',
                    '<%= dirs.jsSrc %>/error.js',
                    '<%= dirs.bowerSrc %>/jt.timepicker/jquery.timepicker.js',
                    '<%= dirs.bowerSrc %>/jt.timepicker/lib/bootstrap-datepicker.js',
                    '<%= dirs.bowerSrc %>/jquery-ui/ui/jquery-ui.js',
                    '<%= dirs.jsSrc %>/time.js',
                    '<%= dirs.jsSrc %>/date-pick.js',
                    '<%= dirs.jsSrc %>/accordion.js',
                    '<%= dirs.jsSrc %>/showrequestscomment.js',
                    '<%= dirs.bowerSrc %>/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
                    '<%= dirs.jsSrc %>/requests_vacation.js',
                    '<%= dirs.jsSrc %>/currentpage.js',
                    '<%= dirs.bowerSrc %>/fullcalendar/dist/fullcalendar.min.js',
                    '<%= dirs.jsSrc %>/calendar.js'
                ]

            },
            css: {
                nonull: true,
                dest: '<%= dirs.dest %>/app.css',
                src: [
                    '<%= dirs.bowerSrc %>/font-awesome/css/font-awesome.css',
                    '<%= dirs.cssSrc %>/template-styling.css',
                    '<%= dirs.bowerSrc %>/bootstrap/dist/css/bootstrap.css',
                    '<%= dirs.bowerSrc %>/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css',
                    '<%= dirs.bowerSrc %>/startbootstrap-sb-admin-2/dist/css/timeline.css',
                    '<%= dirs.bowerSrc %>/jquery-ui/themes/smoothness/jquery-ui.css',
                    '<%= dirs.cssSrc %>/errors_css.css',
                    '<%= dirs.bowerSrc %>/jt.timepicker/lib/bootstrap-datepicker.css',
                    '<%= dirs.bowerSrc %>/jt.timepicker/jquery.timepicker.css',
                    '<%= dirs.cssSrc %>/vacation_request.css',
                    '<%= dirs.bowerSrc %>/fullcalendar/dist/fullcalendar.css'
                ]
            }
        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                compress: {
                    global_defs: {
                        "DEBUG": false
                    },
                    dead_code: true,
                    drop_console: true
                },
                preserveComments: false
            },
            dist: {
                files: {
                    '<%= dirs.dest %>/app.min.js': ['<%= dirs.dest %>/app.js']
                }
            }
        },
        cssmin: {
            dist: {
                files: {
                    '<%= dirs.dest %>/app.min.css': ['<%= dirs.dest %>/app.css']
                }
            }
        }
    });

    // Load the plugin that provides the required tasks.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    // Default task(s).
    grunt.registerTask('default', ['concat', 'uglify', 'cssmin']);

};