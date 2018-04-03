let mix = require('laravel-mix');

class Example {
    webpackRules() {
        return {
            test: /\.test$/,
            loaders: []
        };
    }
}

mix.extend('foo', new Example());
