cd c:/wamp/www/

pscp c:/wamp/www/application/controllers/crons/Inventory.php gsl@192.168.17.111:/var/www/application/controllers/crons


pscp c:/wamp/www/application/controllers/inventory/Dashboard.php gsl@192.168.17.111:/var/www/application/controllers/inventory
pscp c:/wamp/www/application/models/inventory/Minventory.php gsl@192.168.17.111:/var/www/application/models/inventory
pscp c:/wamp/www/application/models/interfaces/Mwms.php gsl@192.168.17.111:/var/www/application/models/interfaces
pscp c:/wamp/www/application/views/inventory/replenishment_list.php gsl@192.168.17.111:/var/www/application/views/inventory

pscp c:/wamp/www/application/views/inventory/excel_replenishment_list.php gsl@192.168.17.111:/var/www/application/views/inventory
pscp c:/wamp/www/application/views/excel_header.php gsl@192.168.17.111:/var/www/application/views


pscp c:/wamp/www/application/views/main_left_menu.php gsl@192.168.17.111:/var/www/application/views



pscp hesh -r gsl@192.168.17.111:/var/www/hesh