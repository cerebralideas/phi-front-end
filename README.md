# **phi**: A Web-App Toolkit and Modular Framework
## Do not use this. It is still in rapid development and in a pre-release stage.
## Status: Version 0.14-alpha — Currently: missing core app features; in cross-browser and cross-device testing.

The goal of this project is to create a web application toolkit and framework that's built with the best in modern technology, test-driven and incorporates the modular approach to application design. This is also a very opinionated stack that focuses on an intimate alignment and integration with the needed components to build a successful web-app, rather than a mash-up disparate technologies.

## What Will Version 1.0 of phi Include?
### App Features That Extend AngularJS (ALMOST DONE):
#### Core Services

1. CRUD API (IN PROGRESS)
1. Client-side model (data object) manipulation API (IN PROGRESS)

#### Components (Directives)

1. Click-event delegation (DONE)
1. Date validation & format automation (DONE)
1. Phone number validation & format automation (DONE)
1. Time validation & format automation (ALMOST DONE)
1. Basic alert functioning & management (DONE)

### UI & Ix Features (DONE):
#### Core Features
##### Built-in, default features

1. Compass & Sass Driven (DONE)
1. CSS Normalization (DONE)
1. Grid system with two types (DONE)
	* `inline-block` type
    * `table-cell` type
1. Typographic ruleset (DONE)
1. Button styling and features (DONE)
	* Primary, secondary and tertiary styles
	* Group and button bar features
1. Navigational styling and features (DONE)
	* Horizontal style
	* Vertical style
	* Optional drop-down menu features
	* Tab UI and IxD
1. Basic form styling and features (DONE)
1. Basic media queries (DONE)

#### Extensions
##### These are 'pluggable' widgets

1. Tabbed UI (DONE)
1. Helper Classes (DONE)
	* Breadcrumbs
	* Labels
	* Panels
	* Progress Bars
	* Img Thumbnails
	* Inline Lists
	* Flexible Videos
1. Modals with multiple, desktop sizes (DONE)
1. Wayfinding navigation (section aware) (DONE)
1. Alerts (DONE)
1. Date Picker (DONE)

### Misc. Tasks left before 1.0 release

1. Integrate CRUD API into demo.
1. Complete and integrate angular model API into demo.
1. Provide client-side routing demo.

## What Are Planned Features (version 1.5)
### App Features That Extend AngularJS:
#### Components (Directives)

1. Highly advanced alert & notification system
1. Angular integrated modal + content viewer (e.g. go to next or prev within modal)
1. Custom multi-select integration
1. Advanced multi-group toolbar integration

### UI & Ix Features:
#### Extensions

1. More advanced responsiveness with JS and media queries
1. Integrate scrolling animation to Wayfinder nav.
1. Click driven popovers and tooltips
1. Content carousel
1. Image gallery/viewer
1. Accordion
1. Toolbar UI
1. Improve responsiveness for mobile
	* Responsive tables
	* Make vertical tabs more mobile friendly version
	* Make Wayfinder more mobile friendly version
	* Collapsible Navigation

### Suggested Features

1. Event Driven Notifications by User / Re-Useable Errors and Alerts (This will be a WIP for a bit)
	* Must not be removed on close
	* Custom notifications per page
	* I would like to see it as a JS array
	* Instantiated on the Layout Page
1. Form validations (AngularJS handles validation natively)
	* Validations that cross boundaries between PHP and Javascript
	* Errors and notifications that are the same on both sides

## Below is a list of the integrated technologies:

- UI & Ix Framework based off of [Zurb's Foundation](https://github.com/zurb/foundation)
- [HTML5 Boilerplate](https://github.com/h5bp/html5-boilerplate)
- [AngularJS seed](https://github.com/angular/angular-seed)
- [jQuery with differing build versions](https://github.com/jquery/jquery)
- [Lo-Dash: A JS utility library](http://lodash.com/)
- [Modernizr](https://github.com/Modernizr/Modernizr)
- [Waypoints Plugin](https://github.com/imakewebthings/jquery-waypoints)
- [Node.js](https://github.com/joyent/node) & [Grunt](https://github.com/gruntjs/grunt)
- [Compass](https://github.com/chriseppstein/compass) and [Sass](https://github.com/nex3/sass)
- [Testacular](https://github.com/vojtajina/testacular) & [Jasmine](https://github.com/pivotal/jasmine)

I'd like to thank all the teams responsible for the above listed technologies and their generous open-source philosophies. Because of these great people and their openness to sharing, we are allowed to stand on the shoulders of those that come before us. Thank you.
