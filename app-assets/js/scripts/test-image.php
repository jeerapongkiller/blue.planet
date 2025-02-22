<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #my-node {
        width: 500px;
        height: 500px;
        /* border: 1px solid black; */
        background-color: #fff;
    }
</style>

<body>

    <div id="my-node">
        <p>Some HTML content or images.</p>
    </div>
    <button id="button">Take Image</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="node_modules/dom-to-image/src/dom-to-image.js"></script>
    <script>
        $(document).ready(function() {
            $("button").click(function() {
                var node = document.getElementById('my-node');
                domtoimage.toJpeg(document.getElementById('my-node'), {
                        quality: 0.95
                    })
                    .then(function(dataUrl) {
                        var link = document.createElement('a');
                        link.download = 'my-image-name.jpeg';
                        link.href = dataUrl;
                        link.click();
                    });
            })
        })
    </script>
</body>

</html>