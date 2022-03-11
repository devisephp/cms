let mix = require("laravel-mix");

mix
  .setPublicPath(path.normalize("."))
  .copy("node_modules/devisephp-interface/build", "build/");
