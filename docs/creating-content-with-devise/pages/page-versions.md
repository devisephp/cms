---
description: >-
  Page versions allow you and your content managers to create copies of a page
  and make changes before making them live. These pages can be used for schedule
  content publishing and (soon) A|B testing.
---

# Page Versions

{% hint style="warning" %}
If you are just getting started on Devise this is a section that you may want to return to after getting your feet wet.
{% endhint %}

## What is a version?

Page versions are copies of a page that all are located at the same url. Obviously, only one version of page can render for a user at a time so you can set when pages are available to be seen by end users. This gives your team a chance to make edits secretly and review those changes without interrupting the end user experience. 

### What version is Live?

All pages have a "Default" version to start and that is the version that the universe sees when they visit the URL of the page. To see all your versions **click the gear** on the sidebar and then **Pages.** Click **Edit a Page** and search for the page you want to manage the versions of. Choose it and then click **Manage Versions**. Here you should see something similar to the following:

TODO: Screenshot of page version editor

As you can see the top of the live version of the page will say "Currently Live". 

### Create a new version

To create a new version click the copy button at the bottom of the version you wish to begin working from. This will create a "\[Name of original version\] Copy" version of the page. Congratulations! You've created your first new version of a page. While we are here let's check out the settings. On versions editor you can change:

* **Version Name:** This is for internal purposes only. So you might name a page "Black Friday 2020 Special Offer" or whatever makes the most sense to your team. 
* **Layout**: The layout is the main wrapper of the page. This allows you to change the entire look and feel of the page.
* **Start Date:** When this version will go live. The version with the most recent start date \(assuming the end date hasn't happened yet\) is live.
* **End Date:** When the version is retired. Don't worry, it isn't deleted. Devise just rolls back to the version that has the latest start date.

## Viewing and Editing Versions

Ok, so we have a new version - how do we view it? Well, there are two ways. If you head back to the main editor on the page that contains the versions you will see a dropdown box at the top. This is the **page version selector** which will allow you to preview any page version. 

**TODO: Screenshot of page version selector.**

Additionally, if you select **Time Travel Preview** you can select any date on the calendar which will let you see how the page will look on that day. It will take into account the page version that should be presented at that moment in time based on your start and end dates.

