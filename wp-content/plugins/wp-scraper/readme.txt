=== WP Scraper ===
Contributors: Allyson Rico, Robert Macchi
Tags: wp scraper, scraper, website scraper, content scraper, content copier, copy, website copier, web scraper, scraping
Requires at least: 
Tested up to: 4.6
Stable Tag: trunk 

This Wordpress Scraper allows you to copy content from other websites to create your posts and pages.

== Description ==

= Building A Website Has Never Been Easier =

Automatically copy pages of content with images from another website and create your own Wordpress pages and posts. 

Most of the web scraper software available is hard to use and needs advanced knowledge. WP Scraper makes it simple with an easy to use visual interface on your WordPress site.

In this version, the Single Scraper is fully functional and the Multiple Scraper is limited to ten posts at a time. The Live Scrape feature which allows you to update your scraped content on schedule is only available with the pro version. 

* Visual interface for selecting content.
* No need to know CSS selectors.
* Scraped images are imported to your media library.
* Simply add your url and start grabbing content.
* Retrieve a list of webpages to scrape content from.
* Automatically populate the featured image, title, tags, and categories.
* Save as draft, post, or page.
* Strip unwanted css, iframes, and/or videos from content
* Remove links from the content.
* Post to a selected category.
* Remove the content retrieved link for migrated posts.

The WP Scraper Pro version allows unlimited posts and pages with the Multiple Scrape. The Pro version also has a fully functional Live Scrape feature that allows automatically refreshed content for ratings, reviews, scores, rankings and so much more! Please visit http://www.wpscraper.com/ for more information.

[youtube https://www.youtube.com/watch?v=eHBMC3VNGJk]


== Installation ==

Installation
Uploading via WordPress Dashboard

1. Navigate to the ‘Add New’ in the plugins dashboard
2. Navigate to the ‘Upload’ area
3. Select wp-scraper.zip from your computer
4. Click ‘Install Now’
5. Activate the plugin in the Plugin dashboard

Using FTP

1. Download wp-scraper.zip
2. Extract the wp-scraper.zip directory to your computer
3. Upload the wp-scraper.zip directory to the /wp-content/plugins/directory
4. Activate the WP Scraper plugin in the Plugin dashboard

== Usage ==

= Single Scrape =

*URL
Enter the URL you wish to copy content from.

*Title
You may select a title from the source page or add your own.

*Post Content
You may select multiple areas of the source page including images.

Post Type
Post Type: Post, Page – Status: Published, Draft, Pending Review

Options
Only Text and Images – Checked will remove all html elements except p, div, table, list, break, headings, span, and images. CSS will not be included with this option and links and videos are automatically removed. 
Remove Links – Checked will remove all external links from the content.
Add source link to the content – Checked will Add source link to the content.

Categories
Select a category or create a new one.

Tags
Select tags from source page or add your own.

Featured Image
Select an image from the source page or add your own.

* Required 

= Generating URL’s =

** This version is limited to creating ten posts or pages with multiple scrape, even if you generate more than ten urls.

Domain Pattern:

Only follow links with the same url. – www.example.com and sub.example.com

Only follow links with the same domain. – www.example.com not sub.example.com

Only follow links in the same path as the given url. – If the url is
www.example.com/path/index.html, only get urls in www.example.com/path/

Skip Links:
Optionally skip a certain number of links. This is useful if you have already scraped a number of links from a website and want to scrape more pages now. For example, if you already created posts with 10 links from this url, and now you want to grab the next 10 links, you would enter 10 into the box above.

Depth Limit:
Optionally set the depth limit for crawling pages. If this value is set to 1, it will only gather webpages that are linked on the entry page. If it is set to 2, it will also gather all webpages linked to the pages found on the entry page.

Request Delay: Seconds
Optionally delay each request to the url. This can keep your site from making too many requests at once to the url.

Path Matching: Contains – Ends with
Optionally add a word to match within urls.
For example, choosing “contains foo” above would only add webpages to the list that have “foo” in the path such as example.com/foo or example.com/path/this-page-has-foo

Note: The list of URL’s will vary in quantity and accuracy depending on the site your retrieving them from.

= Multiple Scrape =

*Titles
*Select a title from source page or add your own.

*Post Content
*You may select multiple areas of the source page including images.

Post Type
Post Type: Post, Page – Status: Published Draft, Pending Draft

Options
Only Text and Images – Checked will remove all html elements except p, div, table, list, break, headings, span, and images. CSS will not be included with this option and links and videos are automatically removed. 
Remove Links – Checked will remove all external links from the content.
Add source link to the content – Checked will Add source link to the content.

Categories
Select a category or create a new one.

Tags
*Select tags from source page or add your own.

Featured Image
*Select an image from the source page or add your own.

*If you type in your own content into the multiple scraper fields then the content will be repeated throughout all the posts.

*If you choose the content from the source page for any of these fields then the scraper will find and add the content to each post.

*Required

This version is limited to creating ten posts or pages with multiple scrape.

== Screenshots ==

1. Using the Single Scrape.

2. This is how easy it is to choose content from another website.

3. Using the url generation tool.

4. The Results page lists each post as it is created. Remember that this version is limited to only ten posts or pages at a time. Visit http://www.wpscraper.com/ for more information.

== ChangeLog ==

= Version 1.0 =

* Initial version of this plugin.

= Version 2.0 = 

* Added additional fields to the single scraper
* Added a limited version of the multiple scraper which is available in the WP Scraper Pro version.

= Version 2.4 =

* Various bug fixes
* Added the Only Text and Images option for simplified scraping use. 

= Version 3.0 =

* Edited visual interface and various bug fixes.

= Version 4.0 = 

* Redesigned selector interface, and corrected issue with shared hosting servers.

= Version 4.1 =

* Tested and updated for Wordpress 4.6 release