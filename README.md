## ycon connector task

Hi!
This is a little challenge to see how you approach and solve tasks using laravel framework.

This is a simple application using laravel 8. You can run it with laravel sail.

ycon.ONE is all about "shipments". A shipment is a transport from Location A to location B
with whatever mode of transport (Road,Rail,Sea,Air).
For every shipment ycon.ONE collects positiondata on a regular basis to let the client know 
where his shipments are and what route they have taken.

### setup

To get started, go to your terminal and start the containers with:

	mv .env.example .env
	composer install
	vendor/bin/sail up -d

(On the first run give docker a little time to setup the database. Otherwise the following artisan
commands may fail) 
Then you need to run the migrations once and seed the database

	vendor/bin/sail artisan config:cache
	vendor/bin/sail artisan migrate
	vendor/bin/sail artisan db:seed
	
Now you should be able to see the frontend under
		
	http://127.0.0.1/
	
Login with
	Username: admin@admin.com
	Password: admin
	
	
### the task

to get gps positiondata into the system we need to call different webservices that provide 
this positiondata. Your task is to get the positiondata from a certain dataprovider into the system
If you have run the migrations there are serveral shipments in the database.
Write an artisan command that fetches the current position of every active shipment (status == ACTIVE)
and stores it into the database every five minutes. 

Every shipment has an attribute gpsdevice_id. This is a unique identifier of the gpstracker that is onboard
of the truck. You will find this id in the response of the webservice. Not every deviceid is present in the
webservice response. Only use the positions that can be assigned to a known gpsdevice_id.

### the result

Please write the code that is needed to fulfill the task (Codestyle PSR-1 and PSR-2). We also expect your code to be covered by unittest
(we use phpunit). 
Please also include an indcation of how long it took to complete the task.
