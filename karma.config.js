/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


module.exports = function(config){
    
    config.set({
        
        // base path that will be used to resolve all patterns (eg. files, exclude)
        basePath: '',


        // frameworks to use
        // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
        frameworks: ['jasmine'],


        // list of files / patterns to load in the browser
        files: [
            'assets/libs/angular/angular.js',
            'assets/libs/angular-mocks/angular-mocks.js',
            //'assets/libs/lodash/dist/lodash.compat.min.js',
            'assets/libs/angular-route/angular-route.js',
            //'assets/libs/restangular/dist/restangular.js',
            //'assets/libs/angular-bootstrap/ui-bootstrap-tpls.js',
            'assets/libs/jquery/dist/jquery.js',
            'assets/libs/moment/moment.js',
            'assets/libs/angular-toastr/dist/angular-toastr.js',
            'app/components/**/*.js',
            'app/components/**/*.spec.js'
        ],


        // list of files to exclude
        exclude: [
        ],


        // preprocess matching files before serving them to the browser
        // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
        preprocessors: {
            'app/components/**/!(*.spec|partials|app).js': 'coverage'
        },

        coverageReporter: { // name => coverage
            reporters: [
                { type: 'html', dir: 'Reports/coverage', subdir: '.' }
            ]
        },

        

        // test results reporter to use
        // possible values: 'dots', 'progress'
        // available reporters: https://npmjs.org/browse/keyword/karma-reporter
        reporters: ['progress','junit'],
        junitReporter : { // name => junit
         outputFile: 'Reports/coverage/TestResultsUI.xml'
        },
        // web server port
        port: 9876,


        // enable / disable colors in the output (reporters and logs)
        colors: true,


        // level of logging
        // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
        logLevel: config.LOG_INFO,


        // enable / disable watching file and executing tests whenever any file changes
        autoWatch: true,


        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: ['PhantomJS'],


        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: false
    });
};