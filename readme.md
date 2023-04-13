# Installation guide

***it is recommended to install automatically using composer but you can also install manually if necessary***

## automatic:


**Step one:**

Navigate to the root of the Oxid eshop you want to install this module on.

	
**Step two:**

Open the terminal and execute: 

	composer require fcseb/banner 
to download and install the latest stable version of this module.

	
**Step three:**

Open the admin page of your Oxid eshop. Navigate to the "Modules" table. You should see that the Module was installed successfully.
	
## manual:


**Step one:**

Navigate to the root of the Oxid eshop you want to install this module on.

	
**Step two:**

Open the Terminal and execute 

	git clone https://github.com/FC-Sebastian/Oxid6_PromotionBanner source/modules/fcSeb/banner
	
OR
	
Navigate to source/modules and create a folder named "fcSeb" and within that newly created folder create another one named "banner".
Download a stable version of this module from https://github.com/FC-Sebastian/Oxid6_PromotionBanner 
and paste it into the "banner" folder.

	
**Step three:**

Navigate to the root of your Oxid ehop open the Terminal and execute

	vendor/bin/oe-console oe:module:install-configuration source/modules/fcSeb/banner
	
	
**Step four:**

Open the Terminal and execute 

	composer config repositories.fcseb/banner path source/modules/fcSeb/banner
Finally execute 

	composer require fcseb/banner

	
**Step five:**

Open the admin page of your Oxid eshop. Navigate to the "Modules" table. You should see that the Module was installed successfully.

### notes:

>This module was testet on Oxid ehop Versions 6.4 and 6.5 but should work on all Oxid 6 ehops.