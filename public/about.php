<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page</title>
</head>
<body>
    <?php require('header.php')?>
    <div class="img">
    <div class="content">
        <h1>About</h1>

        <div class="ainfo">
            <p class="htxt">Subheading for description or instructions</p>
            <p class="desc">Body text for your whole article or post. We’ll put in some lorem ipsum to show how a filled-out page might look:</p>
            <p class="hinfo">Excepteur efficient emerging, minim veniam anim aute carefully curated Ginza conversation exquisite perfect nostrud nisi intricate Content. Qui  international first-class nulla ut. Punctual adipisicing, essential lovely queen tempor eiusmod irure. Exclusive izakaya charming Scandinavian impeccable aute quality of life soft power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter destination Toto remarkable officia Helsinki excepteur Basset hound. Zürich sleepy perfect consectetur.</p>
        </div>

        <h3>Contact me</h3>
    </div>
    <div class="img"><img src="images/ооооееее.jpg" alt=""></div>
    </div>
    <form action="" class="form" method="post">
        <div class="column">
            <div class="input">
                <label>First name</label>
                <input type="text" placeholder="John">
            </div>
            <div class="input">
                <label>Last name</label>
                <input type="text" placeholder="Doe">
            </div>
        </div>
            <div class="input" id="email">
                <label>Email adress</label>
                <input type="email" placeholder="johndoe@email.domain">
            </div>
            <div class="input" id="msg">
                <label>Your message</label>
                <textarea name="message" placeholder="Enter your message"></textarea>
            </div>
            <button type="submit" id="submit">Submit</button>
    </form>
    
</body>
</html>

