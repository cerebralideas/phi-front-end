/* Set some jshint global vars */
/*global require: true*/
/*global module: true*/
module.exports = function(grunt) {

  // Create a new multi task.
  grunt.registerMultiTask('macreload', 'This reloads your browser and switches back to your editor (mac only).', function() {

    // we want this to be asynchonous
    var done = this.async();
    var exec = require('child_process').exec;
    var back = this.data.back;
    var browser;
    var editor;
    var browserName = '';
    var command = '';


    switch(this.data.browser) {
      case 'chrome':
        browser = 'Chrome';
        browserName = 'Google Chrome';
        break;

      case 'canary':
        browser = 'Canary';
        browserName = 'Google Chrome Canary';
        break;

      case 'firefox':
        browser = 'firefox';
        browserName = 'firefox';
        break;

      case 'opera':
        browser = 'Opera';
        browserName = 'Opera';
        break;

      case 'safari':
        browser = 'Safari';
        browserName = 'Safari';
        break;

      case 'webkit':
        browser = 'WebKit';
        browserName = 'WebKit';
        break;
    }

    switch(this.data.editor) {
      case 'macvim':
        editor = 'MacVim';
        break;

      case 'textmate':
        editor = 'Textmate';
        break;

      case 'sublime':
        editor = 'Sublime Text 2';
        break;

      case 'terminal':
        editor = 'Terminal';
        break;

      case 'iterm':
        editor = 'iTerm';
        break;
      // you can add more here if you want
    }


    function puts(error, stdout, stderr) {
      if (error !== null) {
        // just ignore the error, log it but proceed
        grunt.log.error(error + 'Could not refresh - are your browser and editor open?');
        done(true);
      }
      else {
        done(true);
        grunt.log.write('Browser refresh complete.');
      }
    }


    if (browser !== undefined) {
      grunt.log.write('Refreshing Browser... ');

      command += "osascript -e 'tell app \"" + browserName + "\"' -e 'activate' ";
      command += "-e 'tell app \"System Events\" to keystroke \"r\" using {command down}' -e 'end tell'";
      if (editor !== undefined) {
        command += " && osascript -e 'tell app \"" + editor + "\"' -e 'activate' -e 'end tell'";
      }

      exec(command, puts);
    }

  });
};

