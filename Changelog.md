# Change Log 

============================================
Members: Matthew, Dennis, Injo, Haram, Lydia

2016-12-11 12:1 - Dennis
- Updated Dashboard to use order receipts to do calculations

2016-12-11 10:44 - Dennis
- Updated orders to save in respective directories
- Updated orders to save in sequential order numbers
- Added padding to <td> elements

2016-12-11 04:45 - Matthew
- Updated generateReceipt() in Order model
- Added Summary view
- Can select individual receipts to view from summary view
- Added Receipt view
- Edited sales_List view to have Summary
- Edited production_list view to have Summary
- Edited receiving_list view to have Summary
- Summary now works for Sales, Production and Receiving

2016-12-10 22:41 - Matthew
- Created Order model
- Order model can save orders as xml
- Order model can generate receipts
- Order model can load data from xml
- Changed Sales controller to use Order model for receipts
- Edited sale_confirmation view

2016-12-10 21:39 - Lydia
- Edited production controller Craft method, update product stock number after crafting.

2016-12-10 20:20 - Haram
- Edited methods in Dashboard controller to take in values from backend and database for product, material, and recipe.
- Took out methods that wasn't using to clean out the code for material model and dashboard controller.

2016-12-10 19:16 - Dennis
- Bugfix: warning in maintenance edit triggers duplicate id warning in subsequent submissions
- Bugfix: Maintenance URL stays at post url after a post, causing problems for the previous button
- Styled new maintenance buttons 

2016-12-10 17:48 - Injo
- sales controller updates the value to the db accordingly
- production controller updates the value to the db accordingly
- set num field helper min values to 0 for sales and receiving controller and 1 for production, they no longer get negative values

2016-12-10 11:37 - Injo
- Updated Sales Controller
- updating to db still on the work

2016-12-09 22:57 - Injo
- minor changes from production controller

2016-12-09 20:26 - Dennis
- Updated Products model for CRUD operations
- Modified recipes CRUD code in Maintenance controller to be generic to accomodate products
- Dropped recipeId column from products table

2016-12-09 19:07 - Dennis
- Updated Recipes model for CRUD operations
- Implemented CRUD for recipes in Maintenance controller 
- Updated admin.js to use updated tab names
- Updated MY_Controller to use updated tab names

2016-12-08 20:59 - Lydia
- Modified sales controller to show product list and single product

2016-12-08 20:02 - Lydia
- Edited recipe model and product model
- Modified recipe controller (need to edit craft method)

2016-12-08 17:28 - Dennis
- Maintenance controller materials PUT, POST, DELETE complete.
- Modified Materials model for validation, api requests
- Renamed Admin routes to Maintenance 

2016-12-08 17:10 - Haram
- Converted the receiving controller to match the new material model
- Implemented the update feature in receiving controller to update the amount of materials by user input.
- changed the material model accordingly.

2016-12-08 13:25 - Haram
- Changed the receiving controller to take in material api and populate the table.
- Disabled some features on dashboard to get it working (temporarily)

2016-12-08 12:55 - Dennis
- Maintenance controller materials read complete

2016-12-08 00:42 - Dennis
- Consolidated recipe and product tables, renamed materialcombo table to recipe
- Replaced missing libraries and helpers in autoload

2016-12-07 19:44 - Haram
- Added front-end sql statements for Recipe, product, and materialcombo. Including migration.
- Added parsedown library because it was required

2016-12-07 14:37 - Matthew
- Added toggle Controller
- Added toggle option to template
- Can change user role to Guest , User or Admin

2016-12-07 14:08 - Injo
- installed caboose and REST and modified autoconfig accordingly

2016-12-07 13:22 - Dennis
- Added database.config to gitignore

2016-12-07 13:12 - Lydia
- Copied assignment 1 into new repository
- Added changelog
