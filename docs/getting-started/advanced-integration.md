## Advanced Integration with VueJS

Let's suppose that you want to add on a new administration section in Devise or build in your own VueJS components so that Laravel Mix and Webpack can do their thing and optimize your build? Well, we've set it up so that you can do that fairly easily.

### General Requirements

These requirements are not completely set in stone. It's just how we've been able to get the most dependable results from Webpack and Laravel Mix in our build routine. Laravel Mix 2.x _will_ work but getting the package sizes down was a struggle for us.

- Webpack 4
- Laravel Mix

### Get the Devise Interface Source

`yarn add devisephp-interface`

or

`npm install devise-interface`

> For the rest of this document we will reference yarn only but typically you can use npm commands if you prefer

### Update
