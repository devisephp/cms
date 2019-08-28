# Creating Sites

## Multisites in Devise

Through the installer Devise will setup your first website. After you are up and running Devise will support an unlimited number of websites and domains. All sites can utilize slices and data from one another so you can leverage layouts and maintain branding guidelines easily.

## Creating additional sites

When you are ready to create additional sites in Devise login to your first site and click the gear icon. Select "Sites" from the main menu, click "Create New Site", and fill the form out appropriately.

**Name:** This is just a label for the site in the administrative section.

**Domain:** This should be the production domain of the site.

**Default Language:** The fallback language when a page isn't present in a particular language.

Once you have filled out the form you need to make your first page for the site. Devise makes no assumptions about you needing a homepage so currently it's going to return a 404. So head on over to the "Pages" section and create your first page for this site \(probably the homepage\) and then point your browser to the new site's domain and it should render \(ensure that your domain is pointed to the IP.

If you are developing locally on something like Laravel Valet be sure to add the domain override to the .env.

```text
SITE_2_DOMAIN=mynewsite.test
```

### Notes on Multiple site overwrites

Route caching will not work with multiple domain overwrites

### Notes on Laravel Valet

In your park folder make sure you setup a symlink to your projects main folder and name your link the domain you set above. For example:

```text
ln -s ~/Code/maindomain ~/Code/mynewsite
```

