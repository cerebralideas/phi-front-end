# grunt-macreload

This small grunt-plugin can be used to reload your browser on OSX.
I use it to refresh the browser automatically after JS/Compass-compilation, 
without using tools like Codekit or LiveReload (which are awesome nonetheless).

## Installation and Usage

Open up your terminal, go to your project and type `npm install grunt-macreload`.
Edit your grunt.js-file and add the macreload-config (example below). Don't forget
to load the task with `grunt.loadNpmTasks()`. I usually add it to my default-task.
This way, everytime a sass- or js-file gets compiled the browser will be reloaded
afterwards. Note that this is a hard reload - you should check your caching-settings
for js/css-files for development to immediatly see the changes.


```
module.exports = function(grunt) {

  ...

  macreload: {
    fuckyeah: {
      browser: 'chrome',
      editor: 'macvim'
    }
  }

  ...

  grunt.registerTask('default', 'lint concat macreload');

  // load the locally installed task-plugin
  grunt.loadNpmTasks('grunt-macreload');

};
```

Supported values for `browser` are:

- `chrome` for Google Chrome
- `canary` for Google Chrome Canary
- `safari` for Apple's Safari
- `opera` for Opera and
- `firefox` for Firefox
- `webkit` for WebKit

Supported values for `editor` are:

- `macvim` for the famous Vim port for OSX
- `sublime` for Sublime Text 2
- `textmate` for Textmate
- `terminal` if you use terminal vim/emacs/whatever
- `iterm` if your use iterm

You can configure grunt-macreload to refresh multiple browsers like this:

```
macreload: {
  safari: {
    browser: 'safari'
  },
  firefox: {
    browser: 'firefox'
  },
  chrome: {
    browser: 'chrome',
    editor: 'textmate'
  }
}
```

The browsers are refreshed in the order you define them.
  
## Notes, License and Bugs

If you don't have your browser open or you have not set the `browser` variable,
nothing will reload. If you have not set the `editor` variable the active window
will stay the browser-window after the refresh. 

Thanks a lot to [kahlil](https://github.com/kahlil/grunt-compass) and his grunt-compass
task that inspired me writing my own grunt task.

Thanks to [alampros](https://github.com/alampros) for adding webkit support.

I don't give a shit about licensing, so do whatever your want with it.
