User Guide
====================

Creating block
--------------
There are two steps to create cms block.
At first step you have to fill four fields:
 1. ID - unique block name (once you create this id, you will not able to change it
 2. Block Type - there are five block types (text, html, image, carousel, php), plus you can to add your own.
 3. Block Name - any name you want to identify this block correctly
 4. Visibility - with this setting you can set it public(show) and protected(hide).
![Create Block Screenshot](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/create_block.PNG)

At second step it can be different quantity of parameters. Here examples for some of existing block types

Text block

![Text Block](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/text_block.PNG) 

Html block

![Html Block](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/html_block.PNG) 

Php block

![PHP Block](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/php_block.PNG) 

Creating page
--------------
For create page you have to fill next fields:
 1. Title - page title 
 2. Route - page id which using in routing to come to this page
 3. Layout - page layout 
 4. Type - page type  
 There are two types of pages which you can create
 First page type is Block type, when page contains your created blocks

 ![Block page](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/block_page.PNG)
 
 When you create block page you can use WYSIWYG to watch your page
 
 ![wysiwyg](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/wysiwyg.PNG)
 
 Second page type is content type, when page contains html
 
 ![Context page](https://raw.githubusercontent.com/NullRefExcep/yii2-cms/master/docs/images/context_page.PNG)
 
 5. Meta Tags - you can set next meta tags to your page:
    - meta title;
    - meta description;
    - meta keywords;
    - meta robots.
