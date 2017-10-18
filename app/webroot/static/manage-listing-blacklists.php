<?php 
session_start();
include('configure/configure.php');

include('auth.php');

$error_message = '';

$error = 0;	

if(count($_POST) > 0)

{

	/*if(trim($_POST['faq_cat_id_main']) == '')

	{

		$faq_cat_error = '<label class="alert-danger fade in">Please Select Sub Category</label>';	

		$error = 1;

	} */

	if($_POST['faq_cat_id'] == 0){

		$_POST['faq_cat_id'] = $_POST['faq_cat_id_main'];

	}

	unset($_POST['faq_cat_id_main']);

	if(trim($_POST['faq_ans']) == '')

	{

		$faq_ans_error = '<label class="alert-danger fade in">This field is required answer.</label>';	

		$error = 1;

	}

	if(trim($_POST['faq_que']) == '')

	{

		$faq_que_error = '<label class="alert-danger fade in">This field is required question.</label>';	

		$error = 1;

	}

	if($error == 1)

	{

		$error_message = '<label class="alert alert-block alert-danger fade in col-lg-12 col-sm-6">Please fillup all required information.</label>';

	}

	else

	{

			$_POST['faq_created_date'] = $current_date;

			$_POST['faq_cat_id'] = $_POST['faq_cat_id'][0];

			$insert_id = insert_data('faq',$_POST);

			if($insert_id)

			{

				header('location:faq.php');

				exit;

			}

	}	

}

$styles 	 = include_styles('bootstrap.min.css,assets/jquery-ui/jquery-ui-1.10.1.custom.min.css,bootstrap-reset.css,font-awesome.css,jquery-jvectormap-1.2.2.css,css3clock/css/style.css,morris-chart/morris.css,jquery.wysiwyg.css,style.css,style-responsive.css');

$javascripts = include_js('lib/jquery.js,lib/jquery-1.8.3.min.js,bootstrap.min.js,accordion-menu/jquery.dcjqaccordion.2.7.js,scrollTo/jquery.scrollTo.min.js,nicescroll/jquery.nicescroll.js,scripts.js,gritter/gritter.js,easypiechart/jquery.easypiechart.js,sparkline/jquery.sparkline.js,flot-chart/jquery.flot.js,flot-chart/jquery.flot.tooltip.min.js,flot-chart/jquery.flot.resize.js,flot-chart/jquery.flot.pie.resize.js,jquery.wysiwyg.js,acco-nav.js');

?>
<?=DOCTYPE;?>
<?=XMLNS;?>
<head>
<?=CONTENTTYPE;?>
<title>Manage Listing Blacklists</title>
<?=$styles?>
<?=$javascripts?>

<!-- Initiate WYIWYG text area -->

<script type="text/javascript">

	$(function()

	{

		$('.wysiwyg1').wysiwyg(

		{

		controls : {

		separator01 : { visible : true },

		separator03 : { visible : true },

		separator04 : { visible : true },

		separator00 : { visible : true },

		separator07 : { visible : false },

		separator02 : { visible : false },

		separator08 : { visible : false },

		insertOrderedList : { visible : true },

		insertUnorderedList : { visible : true },

		undo: { visible : true },

		redo: { visible : true },

		justifyLeft: { visible : true },

		justifyCenter: { visible : true },

		justifyRight: { visible : true },

		justifyFull: { visible : true },

		subscript: { visible : true },

		superscript: { visible : true },

		underline: { visible : true },

		increaseFontSize : { visible : false },

		decreaseFontSize : { visible : false }

		}

		} );

	});

</script>
<script language="javascript" type="text/javascript">

$(document).ready(function(){

var ajax_category_url = 'ajax-faq-dropdown.php';

		//var ajax_category_variation_url = 'ajax-category-variation.php';

		$('.faq_cat_id').live('change',function(){

				

				var cat_parent = $(this).val(); 

				var thisNode = $(this); 

				var data_rel = $(this).attr('data-rel'); 

				$.post(ajax_category_url,{cat_parent:cat_parent,level:0,data_rel:data_rel}, function(data) {

					  if(data != '')

						  $('.first_'+data_rel).remove();

						  thisNode.parent().after(data);

					  $('.faq_cat_parent_id').trigger('change');

				});

				for (var i=Number(data_rel);i<20;i++)

				{

					$('.first_'+i).remove();

				}

				/*$.post(ajax_category_variation_url,{cat_parent:cat_parent,level:0}, function(data) {

						  $('.left-part').html(data);

				});*/

		});

		/*$(".add-new-vari").live("click", function(){

			var txt_obj = $(this).parents('.variation-field').find("input");

			var txt_new_val = txt_obj.val();

			var vari_data_id = txt_obj.attr('data-variation-id');

			var data_id_pk = txt_obj.attr('data-id-pk');

			//if($(".right-part").hasClass('vari-val-'+vari_data_id)){

			var chk_class = $('.right-part .vari-val-'+vari_data_id).length;

			//}

			//alert('.right-part vari-val-'+vari_data_id);

			//$(this).parents('.variation-field').clone().insertBefore($(this).parents('.variation-field'));

			//alert(vari_data_id);

			if(txt_new_val == ""){

				alert("Please Enter Value");

			} else {

				if(chk_class == 0){

					$('.right-part').append('<span class="vari-val-'+vari_data_id+'"><input class="input-short" readonly type="text" value="'+txt_new_val+'" name="variation_data['+vari_data_id+'][]" /><button class="delete-vari">X</button></span>')

				} else {

					$('.right-part .vari-val-'+vari_data_id+':last').after('<span class="vari-val-'+vari_data_id+'"><input class="input-short" readonly type="text" value="'+txt_new_val+'" name="variation_data['+vari_data_id+'][]" /><button class="delete-vari">X</button></span>')

				}

			}

		});

		$(".delete-vari").live("click", function(){

			var par_class = $(this).parent().attr('class');

			var chk_class =$('.right-part '+par_class).length;

			//alert(chk_class);

			var txt_obj = $(this).parents('span').remove();

			

		});*/

});

</script>
</head>

<body>
<section id="container"> 
  
  <?php  include('header.php');?>
   
  <?php include('sidebar.php');?>
  
 
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <section class="panel  border-o">
            <header class="panel-heading btn-primary">Manage Listing Blacklists</header>
            
			<div class="panel-body">
               
					<div class="col-md-4 padding-left-o">
					  <h3>Brand Blacklist
					    <span class="h-tooltip" aria-hidden="true">?</span>  
						  <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
						  </div>
					  </h3>
					  <div class="backlist-editor-box">
						 <textarea rows="25" name="brand" class="zn-blacklist-textarea form-control" id="" data-schema-key="brand">
						 
(a.r.m.s.)
3 sprouts
3skull
4knines
4life
66fit
66fit limited
a b mckinley
a.r.m.s.
ab lounge
ab marketers
abercrombie & fitch
adafruit
addicore
admincosmetics
adobe
adonit
adonit creative inc
adonit creative inc.
adonit replacement discs
adt llc
aergun
aiphone
aircraft technical book company
ak47
alaska airlines
alex and ani
alex and ani, llc
alex perez
alfred dunhill
allergan, inc. (botox)
allsaints
alm productions
altura photo
american educational products
american school of needlework
american scope
american weigh
american weigh scales
american welding society
amiclub
ammogarand
amscope
amway
amy carinn
amzdeal
anolon
antennax
apex tool group
ar-15
ar15
arc'teryx
arcsoft
arm's reach
as seen on tv
ashleigh talbot
assault
assault rifle
audio advisor, inc.
audio-technica
audioquest
auntie anne's
austin city limits
australian gold
author
autism speaks
autodata
autoline products
avery
aviator
avon anew rejuvenate day revitalizing cream
baby bandana drool
babybotte
babybullet
bahco
bananagrams
bandelettes
basilica botanica
baume & mercier
beachbody
beachbody, llc
beadaholique
beauty junkees
bed head
beelink
belkin
bella fascini
bellabe
benchmade
berenguer dolls
best
best selling
bh cosmetics, inc.
big mouth
bigmouth
bigmouth inc
bill lawrence
bill owen
billie w. taylor
bio clean
bkr¨
blazebox
blazekey
blender bottle
blenderbottle
bliss kiss
bloomberg l.p.
blowgun
bluedot trading
bob
boba
bobjgear
body beast
body sculpture
bodylastics
bongoties
bonjour
bonnie plants
boppy
boruit
bose
bottle breacher
bowers & wilkins
bowers and wilkins
bowflex
braven
break ventures
brenda franklin
breville
brian smith
brightech
britax
britax usa
britaxusa
british phonographic industry
broadway basketeers
brochette
browning laboratories
bruce lee
bua
bubblebagdude
bubby babies
bugaboo
bumbleride
burberry
bushcraft essentials
bushnell
busy life
bvlgari
by msr
by torero inflatables
by leatherman
by mountain buggy
cabeau
cable matters
cablewholesale
caboki
cake boss
caliber corporation
california home goods
calutech
camco
cameraquest
cameraquest.
canadian standards association
canadian standards association and pierre d. landry
candycrate
candyshell
canon
canyon dancer
canyon group
capital brands
capital brands / magic bullet
capitalbrands
cards against humanity
cards against humanity llc.
carl's place llc
carlashes
carmick
carolina herrera
cartier
casablanca
caseology
caseology®
casio
cb
cb 72 blank
cbs interactive
cecilio
cellucor
chanel
channel network audio/video surround receiver with bluetooth and wi-fi
chaz dean studio
chicago iron
chicco
chicwrap
chief architect
chloe
chloe & olive
chrysler
circulon
citikitty
citizen
clairecloud
clairecloud inc.
clarisonic
clayful creations becky
clipsandfastenersinc
coach
cobra
cobra electronics
colart
coldwater creek
columbia
conair
confidence fitness
continental enterprises
cooking savior
copper pearl
copperpearl
cosmic debris
cosmic debris etc. inc.
costechusa
coway
cowboy artists of america
cozy sack
craftsman
cramer
creatology
crest
cricut
criswell embroidery & design
criswell embroidery & design sampler cd
crocs
cruise tags luggage
crutcheze
cryso-jad
crystal allies gallery
cushcins
cutco
d&m holdings - denon us
d-click
daiwa
dakin
daniel wellington
danielwellington
dansko
darice
dark horse comics
david barton
david delamare
deep cleansing oil
dell
delonghi
delta air lines, inc.
demograss
demograss plus
denon
depo
dermalogica
dermawand
designer skin
dewalt
dhc
diageng
digital goja
dihla
directpremiumbuys
dkst
dmbdynamics
dms
dms international
dna
dnp
dr. denese
dreamline
dreamwear nasal mask
drill brush
drive medical
dropcatch
dropcrate
dt moto
dtx international
dudu-osun
dupont
dupont advion
eames office
earthpan
easton
eccotemp systems
eco zoom stove
ecosmart
ecosphere
edgar rice burroughs
edison nation
electro-harmonix
elgy kitchen
elixir / torbeck industries, llc
emjoi
emson
enerlites
enerwave
enfamil
enmotion
epar
epionce
epiphone
epson
epson deutschland gmbh
epsonâ®
ergo baby carrier, inc
ergobaby
escort
esr
esr case
esumic
etienne aigner
evelots
excelmark
excelvan
excelvan®
exel
exel international
explodingkittensllc
farberware
farmland
faswin
fat gripz
fba king inc
fender
fenf
fenf,llc
fields of the nephilim
filemaker, inc.
fishman
fitbit
five-star hotel mattress exceptionalsheets
flex belt
for homegear
ford motor company
foreveryang
formufit
forum novelties
forza
fosbrooke, inc. dba tuft & needle
fossil
frito lay
frux home and yard
fujifilm
fujikam
fujikura
fulvio bianconi
furminator inc. - united pet group
fédération internationale de football association
g40
gaiam
game room guys
gardex
ge
gear tie
gearo
gefu
general electric
genuine stromberg 97
georgia-pacific
gerber
gerber graduates
gibson
global markets direct
glofx
glovies
gn netcom
go pro camera - woodman labs
goal zero
goddess garden
goja, llc
golden gate grinders
golf outlets usa inc
goobang doo master
gopro
gourmesso
gourmet fruit and nut gift tray
gozbit
gratiae
griffin technology, inc
grill beast
grill floss
grilldoc
grillfloss
grimmspeed
grizzly
grover
grover pro
grover pro percussion, inc.
guess
guess marciano
gummee glove
gummy bear mold
guthy-renker
h2m
h2no
hairburst
hairfinity
hairy r's
hang ups
hangerworld limited
hans&alice
harman international industries, inc. (akg acoustics)
hatchbox
haynes and boone
hedley
heirloom finds
helga isager
henckels
henry ware holland
higear design
hipa
hks
home brew ohio
homeplanetgear
hoop for select brother machines
hoover
hoover commercial
horizon hobdistributors, inc. horizon
hot buckles
hot tools
hoverboard
howard elliott
howard elliott collection
hp
human touch®
hunter fan company
hydro mousse
hyundai
i-unik
ibenzer
icd research
idiva
ifixit
ill rock merch
illumibowl
image
inc. browning laboratories
inc. ulead systems
infinity jars
ink and toner
instanatural
instyler
integrity collection
intenze
intenze tattoo ink
intervideo
intuit
iorange-e
iottie
iptvking
iqair
irobot
isotonix
isotonix opc-3
it works
jabra
jackets 4 bikes
jax classics
jaybird llc
jbl
jdmastar
jeannine holper
jemella ltd.
jempire
jet performance
jim pace
jo condrill
jo condrill and bennie bough ph.d.
john deere
jollylife
jrm chemical inc
justin bua
k. denise muth
kalos
karla akins
kasho
kess inhouse
kettle
kevin terry
kevin terry and predestined
kidkraft
kimberly-carr home designs
kinetic sand
king baby
king technologies
king technology
kitchen ezentials
kitchen thing-a-ma-jigs
kitchenero
kleinn air horns
kleinn automotive
kleinn automotive air horns
klipsch
klipsch group
kryptonite
kwiksafety
l'oreal
lamaze
land rover
langley productions
lawn mower cover
leatherman
leebotree
legendary whitetails
lego juris
lets cook
lg
lg electronics
lgelectronics
lgelectronics,inc.
lia sophia
lia sophia and elena kiam
lia sophia and geri berg
lifeproof
lifetrons
lifetrons for people on the move
lightinthebox
lihao
lilian fache
linksys
lip-ink®
lipsy
little trees
liz claiborne
lock pick
lock tools
locksmith
longchamp
luma
luminence, llc
lunchbots
luvvitt
lynda.com
m16
mad about organics
mad dogg athletics
magic bullet
magicfiber
magnetic poetry
malva belle
mamiya
manchester united
mannatech
marantz
marpac
matt groening
mcdavid
mcdavid inc.
mcgregor
mcklein
meal prep haven
meal prep haven stackable
mealprephaven
meaningful beauty
medcosouth
megafood
melaleuca
melissa & doug
melodysusie
melondipity
metropolitan lighting
metropolitan tea
michael josh
microsoft
microsoft corporation
mifanstech
mightymaxbattery
mike barrett
minecraft
minelab
minelab electronics
mitchell repair information company
moen
moichef
mooneyes
moonrays
mountain buggy
mountain khakis
mpd digital
mpowerd
msr
mts / uk home and garden store ltd
my pillow
my recovers
mypillow
mypillow inc
mypillow, inc
myprotein
mystudygroup101 llc
nailstar
nandita singh
nato
natural dog company
naturo sciences
naturosciences
nautilus, inc
neet cables
neetcables
neewer
neocutis
neocutis bio-restorative day cream
neova
nest
netpicks
neutrik
neutrik ag
new era
new sunshine
nialaya
nicer dicer
nike
ninja
nintendo
nissan
nite ize
noble house
noble house home furnishings
nordic naturals
nordstrom
nu skin
nuskin/ pharmanex
nutrabolt
nutri bullet
nutrilite
nuvo
nvid
oasisplus
obagi
oculus
oki data
omiera
omiera labs
omiera labs - omar rx, inc.
online fabric store
onramp technologies
ontel products
open university
opi
oreck
oreck commercial
oreckcommercial
oribe
originalbedband
osmosis
otterbox
oxgord
oxo
oxo good grips
oxo products
packit
packrats collectibles
paco rabanne
palm springs
panasonic
panda wireless
panda wireless inc
pantry elements
paolo soleri
parts express
patu cable ties
paula deen
paw patrol
pawspamper
peleg
penchant
penson & co
perfect crush
peri-k
perkinknives
pestbye
petsafe
pevonia
phiten
photomedex
picking
pipetto
planet pegasus llc
plantronics
platypus
playboy enterprises
playmonster
playtex
plush lined desk eyeglass
pmd personal microderm
pocket hose
pokemon go game tips, cheats, plus, download guide unofficial
polk audio
polybubble
pourfect
powernet
powerstep
pratico
praticokitchen
pratipad
pravda,inc
premier
pro g-flyer party toy
proactiv
pronto moda
prostar deals
protégé beauty
pugster
pugsterjewelry
puig
punk and pissed
pura d'or
purdey's
qm-h
qs
quickfillballoons
quiksilver
r.s.v.p.
rabbito
rachael ray
rachel caine
radiancy
radio systems corporation
razormaid
rdk products
real flame
real techniques starter
rean
rean a brand of neutrik ag
red
red bull
red steagall
refurbished
rembrandt charms
resmed
restoration hardware
revol trading inc
revolver drill brush
rick higgins
ridgerock tools
riorand
riorandtvbox
rockin' paws
rodan + fields
rogeliobueno
roku
roleff
ropri
rosetta stone
rowena cherry
rsvp
rsvp international
rubiks
ruffoni
ruki home
rx 4 hair loss
sado-nation
sally caldwell fisher and chalk & vermilion fine arts
sandvik
santas christmas town
sanyo
scaredy cut
seemecnc
segway inc
seisco international limited
self balancing
selk'bag
sena
sephra
serious steel assisted pull-up bands
serious steel fitness
shaderz
sharkskinzz
sheer strength labs
shenzhen
shop247 usa
shop247.com
shure
sigma
sigma beauty
silalive
silver lined snow globe
silverstone
simien
simplehuman
sivan health
skiboards.com
skinmedica
skip hop
skip,hop,zoo
skullcandy
skycaddie
skystreamx
slendertone
sloggers
smarterfresh
smartsound software
smartwool
smith & wesson
snap-on
snap-on official licensed product
society6
solar water pumping kit
solid strategic
solta medical
songmics
songmics-clothes rack
songmics-jewelry box
songmics-jewelry stand
songmics-laptop desk
songmics-laundry organizer
songmics-makeup case
songmics-shoe rack
songmics-shoe tree
songmics-storage ottoman
songmics-watch box
sony
sound basics
soundbasics
spark and bee
speakstick
speck
speck products
spigen
spigen sgp co., ltd
spin master, ltd
spinido
spoonk
sportdog
sports hoop
sports tek
spyder
squatty potty
stable step
star kids
star shower
star shower motion
starshower
statue of liberty replica
stephen shore
stewart golf
stewartgolf
stl international
studio banana things
stuff2color
stussy
stx international
summer escapes skimmer
sunny health
sunny health & fitness
supco
super power supply llc
supereze
supernight
supreme gear
survival shovel
swagway
swarovski
swiss army brand
symantec
t-cobbler
t-shirt bordello
tactacam
tamiya
tasco
taser international
tasiglobal
techsmith
tedbaker
teeter
teeter hang ups
teeter hangups
tekbotic
telebrands
telescopic rake
tens machine
thane
thane international
thane international, inc
the annenberg foundation trust at sunnylands
the cat personal safety
the joy factory
the modern gummy
the red society
theravent max
thule
tiffany & co.
tom kelley
tomei
tommie
tommie copper
tommy hilfiger
tomy
top greener
topgreener
toppik
torero
torero inflatables
torro
total gym
tottenham hotspur f.c.
tpdc service
traeger
training mask
travelrest
traxxas 6852x
trollbeads
trophy
true image
trx
trx essentials strength
tti floor care north america
tuft & needle
turbotech
tyc
ugg
ugg australia
ugs corp.
ulead
ulead systems
uncommon laundry
under armour
united scope
urepair
useless box
uspicy
vampire squid cards
van cleef & arpels
vanguard
varylala
velvet skin coat
vendibelle
vera bradley
versace
versaliving llc
vickie milazzo
victorio
vigilant
vigilantpersonalprotectionsystems
vinousq
viper
visalus
visalus vi-shape
vivitar
vivre cosmetiques
vogue professional
vonhaus
vortex
vortex optics
waba fun
wacom
wahoo
walker edison
walkydog
warner home video
waterpik
wd music
weathertech
web brands
weber
weider
wemo
wen® chaz dean
werfamily
wise foods
wobbleworks
woodstock amazing grace chime
world by shotglass
woss trainer
wuppessen inc.
wwe
x-mini
x-tronic
xbats
y beauty junkees
y&t
ya
yeti
ykl world
yklworld
yogitoes
yonanas
yopo
young living
young's inc
yvonne hedley
zenoplige
zephyr
zepp
zerosweat
ziggyboard
zildjian
zippyusa
zodiac
zoe+ruth
zully polycarbonate
zumba
zumba fitness
zvue
zwilling j.a. henckels
zyliss
						 
						 </textarea>
					  </div>
					</div>
					
					<div class="col-md-4">
					 <h3>Keyword Blacklist
					      <span class="h-tooltip" aria-hidden="true">?</span>  
						  <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
						  </div>
					 </h3>
					 <div class="backlist-editor-box">
						 <textarea rows="25" name="keyword" class="zn-blacklist-textarea form-control" id="" data-schema-key="keyword"></textarea>   
					  </div>
					</div>
					
					<div class="col-md-4">
					 <h3>Keyword Blacklist
					     <span class="h-tooltip" aria-hidden="true">?</span>  
						  <div class="tooltip"><span>Shipping method to use for products fulfilled from Amazon</span>
						  </div>
					 </h3>
					 <div class="backlist-editor-box">
						   <textarea rows="25" name="product_id" class="zn-blacklist-textarea form-control" id="" data-schema-key="product_id"></textarea>
					  </div>
					</div>
				    <div class="clear"></div> 
	               <br/>
	            <div class="position-center"> 		
					<form  role="form" action="" method="post"> 
					 <input type="submit" class="btn btn-info" value="Save Blacklists"> 
					  <div class="clear"></div> 
					</form>
                </div> 
	   
			  </div>
          </section>
		  
		  
        </div>
      </div>
    

	</section>
  </section>
  
  <!--main content end--> 
  
  <!--right sidebar start-->
  
  <div class="right-sidebar">
    <div class="search-row">
      <input type="text" placeholder="Search" class="form-control">
    </div>
  </div>
  
  <!--right sidebar end--> 
</section>
</body>
</html>