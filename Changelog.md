# Change Log 

============================================
Members: Matthew, Dennis, Injo, Haram, Lydia

2016-12-10 22:41 - Matthew
- Created Order model
- Order model can save orders as xml
- Order model can generate receipts
- Order model can load data from xml
- Changed Sales controller to use Order model for receipts
- Edited sale_confirmation view

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