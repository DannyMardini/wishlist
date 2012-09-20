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

CREATE PROCEDURE PurchaseItem(itemId INT, userId INT, eventId INT, gift_date DATE)
label1: BEGIN
DECLARE prevPurchaser INT DEFAULT -1;
DECLARE itemOwner INT DEFAULT -1;
DECLARE purchaseExists BOOLEAN DEFAULT false;
DECLARE selfPurchase BOOLEAN DEFAULT false;

SELECT user_id FROM Purchase WHERE item_id = itemId INTO prevPurchaser;

# Check to see if purchase already exists
    IF ( prevPurchaser > 0 ) THEN
        SET purchaseExists = true;
    ELSE
        SET purchaseExists = false;
    END IF;

# Problem in this if statement.
    IF ( purchaseExists = true ) THEN

#       Check to see if the item owner is you.
        SELECT user_id FROM Wishlistitem WHERE id = itemId INTO itemOwner;
        
        IF ( itemOwner = userId ) THEN
            SET selfPurchase = true;
        ELSE
            SET selfPurchase = false;
        END IF;

    ELSE
#       if no previous purchase exists let's just create a new purchase.
        INSERT INTO Purchase (item_id, user_id, event_id, gift_date) VALUES(itemId, userId, eventId, gift_date);
    END IF;

    IF ( selfPurchase = true ) THEN
#       delete previous purchase and substitute with your own.
        DELETE FROM Purchase WHERE item_id = itemId;
        INSERT INTO Purchase (item_id, user_id, event_id, gift_date) VALUES(itemId, userId, eventId, gift_date);
    ELSE
        SELECT * FROM Purchase WHERE id=-1;
        LEAVE label1;
    END IF;

    SELECT * FROM Purchase WHERE item_id = itemId;
# Don't do anything if it isn't a self purchase, userId doesn't have precedence over others.
END label1
//