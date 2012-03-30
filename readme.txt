=== Ironclad CAPTCHA WP plugin ===
Contributors: Yeriomin A., Artemev K.
Tags: captcha, image, security, ironclad captcha, security stronghold, spam, spammers, comment, comments, bots, bot, anti spam
Requires at least: 2.3.1
Tested up to: 3.3.1
Stable tag: trunk

3D objects-based CAPTCHA to get rid of spam in comments.

== Description ==
With this plugin you can easily install and use Ironclad CAPTCHA in your WordPress blog. 3D captcha renders several intersecting colored and rotated objects and asks user to count objects of some type. Humans can easily do it (much easier than read twisted text) and bots can't do it at all and never will. Moreover, this captcha stops even spammers with human-based recognition of captchas, as Ironclad CAPTCHA has very unusual answer entering process. Just install the plugin, register and get API key on the official site (for free) and forget about spam forever.

== Installation ==
Unpack archive with plugin into "wp-content/plugins" folder on your WP-based site/blog. You will see "ironclad-captcha" folder with several files there. Log into WP control panel and go to Plugins section. Find "Ironclad CAPTCHA" string in the list of available plugins and click Activate next to it. Plugin is installed now! Don't forget to configure it.

== Configuration ==
Go to Settings section in WP control panel and then to Ironclad CAPTCHA sub-section. You should get API-key to for your blog/site to make Ironclad CAPTCHA appear on it. In order to do this you should register here:

http://www.securitystronghold.com/products/ironclad-captcha/signup/

Then enter your Ironclad CAPTCHA account there, add your site to the list and copy generated API key.Then insert this key into "API key" field on the page of Ironclad CAPTCHA plugin settings inside your WP control panel. The valid API key looks something like IRONCLAD-CAPTCHA-ABCDE-0123456789. After that, Ironclad CAPTCHA should appear in the comments form of your WP blog. Enjoy!

== Frequently Asked Questions ==

Q: Can I change the look and feel of CAPTCHA or make it fit my blog's design?
A: Sure! All styles are contained in "wp-content/plugins/ironclad-captcha/captcha.css". You can change it as you like.

Q: I don't like "Are you a human?" string. I want to type there something different. How can I do this?
A: Log into your Iconclad CAPTCHA account (where you got your API-key), click on Settings link next to the name of your site/blog and change this or several other settings.

Q: My captcha appears under "Send comment" button. Is it possible to move it ABOVE that button?
A: Yes, but due to some limitations of WP you should do it by hand. Don't worry, it's quite easy! Open "wp-content/themes" folder of your WP installation and locate folder with the name of the color theme you use in your WP now. Then locate "comments.php" file inside that folder and change the following string:

<?php do_action('comment_form', $post->ID); ?>

You should move it several lines upper, to make it right below the line with < textarea > definition. Save the file and upload it to your WP site if you edited it locally.

In some versions of WordPress these lines are in wp-includes/comment-template.php file. You should move specified lines above, right before '<p class="form-submit">'.

== License ==
This plugin is free for everyone. Since it's released under the GPL, you can use it free of charge on your personal or commercial blog and alter it any way you like. You must not, however, remove copyright notice implicitly or explicitly, under any conditions. 

== Links and Support ==
About Ironclad CAPTCHA:

http://www.securitystronghold.com/products/ironclad-captcha/

Sign up for API key:

http://www.securitystronghold.com/products/ironclad-captcha/signup/

Log in to the control panel:

http://www.securitystronghold.com/products/ironclad-captcha/login/

Questions? Problems? Wishes? Suggestions?

Then open support ticket here: http://www.securitystronghold.com/support/

We'll be glad to help you!