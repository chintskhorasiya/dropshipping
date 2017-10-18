<section id="container">
    <!--header start-->
    <?php echo $this->element('header'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <main role="main">
                    <article class="main-column col-md-8">
                        <header class="article-header">
                            <h1> How Repricing Works (Full Detail)</h1>
                            <div class="article-info">
                                <div class="article-avatar col-md-2"><img src="https://secure.gravatar.com/avatar/25eea866418a3734ad8ee15f644cd604?default=https%3A%2F%2Fassets.zendesk.com%2Fhc%2Fassets%2Fdefault_avatar.png&amp;r=g" alt="Avatar"></div>
                                <div class="article-meta col-md-8">
                                    <strong class="article-author">
                                        Taylor Gibbard
                                    </strong>
                                    <div class="article-updated meta"><time datetime="2017-01-01T23:27:57Z" title="2017-01-01T23:27:57Z" data-datetime="calendar">January 01, 2017 23:27</time></div>
                                </div>
                                <div class="article-subscribe col-md-2"><a class="article-subscribe btn btn-info" rel="nofollow" role="button" data-auth-action="signin" aria-selected="false" href=" ">Follow</a></div>
                            </div>
                            <div class="clear"></div>
                        </header>

                        <div class="article-body markdown">
                            <h3>Important Terms:</h3>
                            <p>Source - The place retailer or market where the item is being purchased. This is often Amazon, Walmart, or AliExpress.</p>
                            <p>Destination - The marketplace where you are selling the item. This is often eBay, Shopify, or Amazon (MFN). </p>
                            <p>You can see all currently supported sources and destinations <a href=" " target="_blank">here</a>.</p>

                            <h3>Repricing Settings</h3>
                            <p>The following settings are available for configuring repricing:</p>
                            <ul>
                                <li>Quantity in stock (default: 1)<br>When a listing is in stock at the Source, Dropshipping will set the quantity on your Destination listing to this number.</li>
                                <li>Minimum Margin (default: 0)<br>Dropshipping will reprice listings to ensure that you receive at least this much profit from each sale.</li>
                            </ul>
                            <h3><a id=" " class="anchor" href=" "></a>Range Repricer</h3>
                            <p><img src="http://support.priceyak.com/hc/en-us/article_attachments/204268386/Screen_Shot_2016-06-08_at_5.33.49_PM.jpg" alt="" height="181" width="223"></p>
                            <p>Watch Doug's video about the Range Repricer here: <a href="https://www.youtube.com/watch?v=jl865Xw83Sc">video</a></p>
                            <p>Dropshipping allows you to specify different margins based on the listing's price at the Source. For example, you could set your profit margin to 10% for listings priced less than $15, but require a 20% margin for listings between $15 and $25, and a 25% margin for listings priced greater than $25. The range repricer can have as many rows as you'd like. Each row has three settings:</p>
                            <ul>
                                <li>Min price<br>The settings from the rest of this row will apply to any listings greater than this price (but less than the price of the next row).</li>
                                <li>Margin percent<br>This is the profit margin that will apply to the listing.</li>
                                <li>Margin fixed<br>This is the fixed margin that will apply to the listing.</li>
                            </ul>
                            <p>Rows can be inserted to this list in any order. Dropshipping will select the row with the highest "Min price" that is still less than the price of the product at the Source.</p>
                            <h3><a id="#" class="anchor" href=" "></a>Margin Calculation</h3>
                            <p>Dropshipping has three variables to help you optimize your profits: Margin percent, Margin fixed, and Margin min.</p>
                            <p>Dropshipping takes the following steps to compute your profit margin:</p>
                            <ul>
                                <li>margin = (Source price) * (Margin percent) + (Margin fixed)</li>
                                <li>if margin is less than (Margin min), set margin = (Margin min) instead</li>
                            </ul>
                            <p>Dropshipping then adds your profit margin to the Source price of the product, accounts for fees, and sets the price on eBay.</p>
                            <h3><a id=" " class="anchor" href=" "></a>Accounting for Fees</h3>
                            <p>Dropshipping computes three kinds of fees and builds these into the price. See "Advanced Settings" below if you'd like to customize these amounts.</p>
                            <ul>
                                <li>eBay Fee<br>Dropshipping accounts for a 10% eBay final value fee.</li>
                                <li>PayPal Fee<br>Dropshipping accounts for a 2.9% + 0.30 PayPal fee.</li>
                                <li>Dropshipping AutoOrdering fee<br>Dropshipping includes our own 0.40 fee.</li>
                            </ul>
                            <p>These numbers may be customized in the advanced settings.</p>
                            <h3><a id="user-content-advanced-settings" class="anchor" href=" "></a>Advanced Settings</h3>
                            <p>For the fees given below, Dropshipping will price your listings to ensure that you receive enough money to cover the fee and still collect your desired profit margin.</p>
                            <ul>
                                <li>Include 0.40 AO Fee (default: no)<br>If checked, Dropshipping will add to your price so you receive an extra 0.40 to cover your AutoOrdering fee.</li>
                                <li>Fixed Payment fee (default: 0.30)<br>This is the fixed component of the fee you pay for receiving a payment. Usually $0.30 for eBay (PayPal) and Shopify, and 0 for Amazon.</li>
                                <li>Percentage Payment fee (default: 2.9%)<br>This is the variable component of the payment fee. Usually 2.9% for eBay (PayPal) and Shopify, and 0 for Amazon.</li>
                                <li>Percentage Marketplace fee (default: 10%)<br>This is the fee charged by the destination on the sale. Usually 10% for eBay, 0% for Shopify, and 8-15% for Amazon (depending on category).</li>
                                <li>Round up prices to end in $0.XX?<br>This setting increases the final price to ensure that it ends in the given number of cents. Unless the price already ends in that number of cents, it will always be increased. To disable, set to an empty box.</li>
                            </ul>
                            <p>For round up prices, an example can be helpful. If "Round up prices" is set to "97" and the price would normally be $12.25, it will be rounded up to $12.97. If the price would normally be $15.99, it will be rounded up to $16.97. And if the price would normally be $5.97, the price will not be changed.</p>
                            <h3><a id="user-content-formula" class="anchor" href=" "></a>Formula</h3>
                            <p>Here's the exact formula that Dropshipping currently follows:</p>
                            <pre><code>(source_price + max(
    (source_price * margin_percent + margin_fixed),
    min_margin
) + ao_fee + payment_fixed) /
(1 - payment_percent - marketplace_fee_percent)
</code></pre>
                            <p>Default values for these variables can be found above. <code>ao_fee</code> is only included if the "Include 0.40 AO Fee" box is checked. <code>margin_percent</code> and <code>margin_fixed</code> are selected based on the Source price in the Range Repricer.</p>
                            <h3><a id="user-content-currency-notes" class="anchor" href="  "></a>Currency Notes</h3>
                            <p>Dropshipping automatically converts between the currency of source and destination markets. For example, if you list amazon.ca products on ebay.co.uk, Dropshipping will convert the price from Candian Dollars (CAD) to British Pounds (GBP). This conversion occurs before computing price, so all pricer settings are in the currency of the destination market (GBP in this example).</p>
                            <p>Also note, Dropshipping does not do any special conversion of fees to account for different currencies. For example, the 0.40 fee for AO is always computed as 0.40 of the destination market currency. If you are using eBay UK or eBay CA, make sure to customize Advanced Fees to account for these differences.</p>
                            <h2> </h2>
                        </div>

                        <div class="article-attachments">
                            <ul class="attachments">

                            </ul>
                        </div>

                        <footer class="article-footer">

                            <div class="article-vote">
                                <span class="article-vote-question">Was this article helpful?</span>

                            </div>
                        </footer>

                        <div class="article-more-questions">
                            Have more questions? <a href="comment-form.php">Submit a request</a>
                        </div>

                        <section class="article-comments">
                            <h3>Comments</h3>



                        </section>

                    </article>

                    <aside class="article-sidebar side-column  col-md-4">
                        <div data-recent-articles=""></div>

                        <section class="related-articles">
                            <h3>Related articles</h3>
                            <ul>

                                <li>
                                    <a href=" ">Pricing and Billing</a>
                                </li>

                                <li>
                                    <a href=" ">ASIN Grabber Tool</a>
                                </li>

                                <li>
                                    <a href=" ">How to edit your shipping, payment, and return information (business policies)</a>
                                </li>

                                <li>
                                    <a href=" ">Repricing Fee Details and Examples</a>
                                </li>

                                <li>
                                    <a href=" ">Coyote (Dropshipping Proxy Service)</a>
                                </li>

                            </ul>
                        </section>


                    </aside>
                </main>

                <footer class="footer">
                    <div class="footer-inner">
                        <!-- Footer content -->
                    </div>
                </footer>



            </div></section></section>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>