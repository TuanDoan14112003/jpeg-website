<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG website enhancements">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Andrew Grivas">
    <title>Website enhancements</title>
	<link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php
        
        $page = 'enhancements';
        include_once('header.inc'); // include the header element
    ?>
    <section class="main-content enhancement-content">
        <section id="hover-effect-section"  class="enhancement-section">
            <section class="section-information">
                <article class="information-container">
                    <h2>Hover Effect</h2>
                    <p>
                        On the home page when the user hovers their mouse over the group members' photos, it expands and changes the colour of the image. Furthermore, a paragraph containing the member's name and email will float up from the bottom. This goes beyond the basic requirements as it uses pseudo-class :hover, pseudo-element ::before, and transitions to create this effect. In addition, this animation also uses the property "transform: translateY()" to change the paragraph's y-coordinate and make it float up.
                    </p>
                    <p>
                        We implemented the hover effect on all of our pages, here is a link to our index.html page to display it:
                    
                        <a href="index.html#footer-section">Index</a>.
                        We used this video and code found online to help code the effect:
                    
                        <a target="_blank" href="https://www.youtube.com/watch?v=nM-30MdKNc4">Hover Effect Video</a>
                    </p>
                </article>
            </section>
            <img id="hover-effect-image" src="images/HoverEffect2.png" alt="Hover effect picture">
        
        </section>

        <section id="text-trail-effect-section" class="enhancement-section">
            <img id="text-trail-effect-image" src="images/TextTrailEffect.png" alt="Text trail effect picture">
        
            <section class="section-information">
                <article class="information-container">
                    <h2>Trail Effect</h2>
                    <p>
                        The text trail effect also called the 'rainbow effect' is a design animation where the text is made to look like it is bouncing up and down. Each layer animation is delayed so it creates the 'trail effect'. The animation was created by using the @keyframes rule and changing the y-coordinates of the layers. This goes beyond the basic requirements as the text needed animation delays and the use of @keyframes.                    </p>
                
                    <p>
                        We implemented the text trail effect on the index.html page linked here:
                    
                        <a href="index.html">Index</a>.
                
                        We used this video and code found online to help code the effect:
                    
                        <a target="_blank" href="https://www.youtube.com/watch?v=ZQUKEkCuws8&t=9s">Text Trail Effect Video,</a>
                
                        <a target="_blank" href="https://codepen.io/mtsgeneroso/pen/mdJRpxX">Text Trail Effect Code</a>
                    </p>
                </article>
            </section>
        </section>
    </section>
    <?php
    include_once("footer.inc"); // include the footer element
    ?>
</body>
</html>
