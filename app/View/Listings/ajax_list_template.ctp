<?php
$template_html = trim(htmlentities($template_data[0]['ListingTemplate']['template']));
//echo $template_html;
//exit;

/* */
$title = "Rubbermaid Easy Find Lids Food Storage Container, 42-Piece Set, Red (1880801)";
$imagepath = "https://images-na.ssl-images-amazon.com/images/I/917dBseIiwL.jpg";
$product_description = "
                                                Size:42-piece Find the right lid, right now! Rubbermaid Easy Find Lids food
                                                storage containers feature lids that snap to the container base and to other
                                                lids, which means the right lid is always at your fingertips. The square-shape
                                                food containers give you more space in the fridge and graduated sizes nest for
                                                cupboard storage. Organizing your kitchen just got easier with Rubbermaid Easy
                                                Find Lids. 42-piece set includes 5 (0.5 Cup), 5 (1.25 Cup), 5 (2 Cup), 2 (3
                                                Cup), 2 (5 Cup), 2 (7 Cup), and all lids.
                                              ";
$post_description = '';

$dimension = array('Size', 'Brand', 'UPC', 'MPN');
$dimension_val = array('42-piece', 'Rubbermaid', '701799110078', 'NA');

$variant_specifics = '';
for ($i = 0; $i < count($dimension); $i++) {
    $variant_specifics .= $dimension[$i] . ': ' . $dimension_val[$i] . '<br>';
}
//echo $variant_specifics;

$product_details =  "
<li>Product Dimensions: 8 x 16 x 10 inches</li>
<li>Item Weight: 3.9 pounds</li>
<li>Shipping Weight: 3.9 pounds</li>
<li>Manufacturer: Rubbermaid</li>
<li>Domestic Shipping: Item can be shipped within U.S.</li>
<li>Origin: USA</li>
<li>Item model number: 1880801</li>
";

$feature_bullets =  "
<li>Lids snap together and to container bases so you can always find the right lid</li>
<li>Graduated sized containers nest for compact storage</li>
<li>One lid fits multiple bases;
Thick, durable container walls for everyday use</li>
<li>Microwave, freezer and dishwasher-safe, BPA-free, Made in the USA</li>
<li>Set includes: 5 (0.5 Cup), 5 (1.25 Cup), 5 (2 Cup), 2 (3 Cup), 2 (5 Cup), 2 (7 Cup);
Lids included</li>
";
/* */
?>

<div class="col-md-6">
    <h3>Code Editor</h3>
    <div class="code-editor-box">
        <pre id="editor">
            <?php echo $template_html; ?>
        </pre>
    </div>
</div>

<div class="col-md-6 return-e">
    <h3>Live Preview</h3>
    <div class="code-editor-box" style="border:1px solid #ccc;">
        <div id="return">
            <?php
            $set_val = array('{{title}}', '{{main_image}}', '{{{product_description}}}', '{{post_description}}','{{variant_specifics}}','{{product_details}}','{{feature_bullets}}');
            $replace = array($title, $imagepath, $product_description, $post_description,$variant_specifics,$product_details,$feature_bullets);
            echo str_replace($set_val,$replace,$template_data[0]['ListingTemplate']['template']);
            ?>
        </div>
    </div>
</div>