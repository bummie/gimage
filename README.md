gImage **Currently broken due to change in google images**
======

- Simple Google Image parser written in PHP. 
- Return image search to table

![alt tag](http://s28.postimg.org/cqs7nvlql/whatssearchapp_lol.png)

Version
----

1.0

Tech
======

Parameters
------

  **Search**
* search - **[String]** - What to search for. 
* type - **[Integer]** - What type of image. Ex face, clipart, photo... 
* size - **[Integer]** - What size. Large and medium. 
* color - **[Integer]** - Coloured image, grey or transparent. 
* licence - **[Integer]** - What kind of licence the images got. 
* safe - **[Integer]** - Not working :) 

  **General**
* amount - **[Integer]** - Amount of images to display.
* disp - **[String]** - How to display the image URL's. 


Table
-----

  **Search**
* search - **[String]** - [ "Cow" ]
* type - **[Integer]** - [ 0.Face, 1.Photo, 2.Clipart, 3.Lineart, 4.Animated ]
* size - **[Integer]** - [ 0.Large, 1.Medium ]
* color - **[Integer]** - [ 0.Colouedr, 1.Grey, 2.Transparent ]
* licence - **[Integer]** - [ 0.Labeled for reuse, 1.Labeled for commercial reuse, 2.Labeled for reuse with modification, 3.Labeled for commercial reuse with modification ]
* safe - **[Integer]** - Not working :) 

 **General**
* amount - **[Integer]** - [ 17 ]
* disp - **[String]** - ["table" - Displays table, "table_img" - Displays table with thumbnails, "plain" - Displays in plain text, "plain_img" - Display in plain text with images ]


