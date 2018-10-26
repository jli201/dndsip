<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="character_list.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <title>Character List/Selection</title>

    <script>
        $(document).ready(function() {
            $('.charSelectBorder').click(function() {  
                $(this).toggleClass('charSelectBorderClicked');
                });
            });
    </script>

    </head>

    <body>
        <div class="heading_div">
            <h1 class="charHeadingBorder"> Characters:</h1>

        </div>

        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>
        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>
        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>
        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>

        <div class="char_div">
            <div class="createChar">
                + Create
            </div>
        </div>

        <div class="heading_div">
                <h1 class="charHeadingBorder"> DM Tools</h1>
        </div>

    </body>
</html>