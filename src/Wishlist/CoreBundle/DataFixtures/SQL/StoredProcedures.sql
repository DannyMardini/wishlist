# Stored Procedure notes:
# To show all stored procedures: SHOW PROCEDURE STATUS

use wishlist;

 DROP PROCEDURE selectPurchase;
 DROP PROCEDURE PurchaseItem;

DELIMITER //

CREATE PROCEDURE selectPurchase()
selectPurchase: BEGIN

INSERT INTO debug VALUES("1");
LEAVE selectPurchase;
INSERT INTO debug VALUES("2");
END selectPurchase
//

# Command for LOADING THE StoredProcedure file: 
# mysql -uroot wishlist < src/Wishlist/CoreBundle/DataFixtures/SQL/StoredProcedures.sql


# This stored procedure will add the new purchase item for this user
# If the item is in this users wishlist, it means he/she is purchasing it for themselves 
# and we must find any other friends of this user who already had this item on their 
# shopping lists for this user. 
# If any are found, remove them. The user has priority over their friends 
# for purchasing an item from their own wishlist. 
CREATE PROCEDURE PurchaseItem(wishlistItemId INT, purchaserId INT, eventId INT, gift_date DATE)
label1: BEGIN
DECLARE prevPurchaser INT DEFAULT -1;
DECLARE itemOwner INT DEFAULT -1;
DECLARE purchaseExists BOOLEAN DEFAULT false;
DECLARE selfPurchase BOOLEAN DEFAULT false;

    # Check to see if someone has already promised to purchase this wishlist item
    SELECT user_id 
    FROM Purchase 
    WHERE item_id = wishlistItemId
    INTO prevPurchaser;

    IF ( prevPurchaser > 0 ) THEN
        SET purchaseExists = true;
    ELSE
        SET purchaseExists = false;
    END IF;

    IF ( purchaseExists = true ) THEN

        # Check to see if the item owner is you.
        SELECT user_id FROM Wishlistitem WHERE id = wishlistItemId INTO itemOwner;
        
        IF ( itemOwner = purchaserId ) THEN
            SET selfPurchase = true;
        ELSE
            SET selfPurchase = false;
        END IF;

        IF ( selfPurchase = true ) THEN
            # delete previous purchase and substitute with your own.
            DELETE FROM Purchase WHERE item_id = wishlistItemId;
            INSERT INTO Purchase (item_id, user_id, event_id, gift_date) VALUES(wishlistItemId, purchaserId, eventId, gift_date);
        ELSE
            # Don't do anything if it isn't a self purchase, 
            # purchaserId doesn't have precedence over others.
            SELECT * FROM Purchase WHERE id=-1;
            LEAVE label1;        
        END IF; 

    ELSE
        # if no previous purchase exists let's just create a new purchase.
        INSERT INTO Purchase (item_id, user_id, event_id, gift_date) VALUES(wishlistItemId, purchaserId, eventId, gift_date);
    END IF;

    SELECT * FROM Purchase WHERE item_id = wishlistItemId;
END label1
//