<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com

    $production         = false;   // toggle to true if going against production
    $compatabilityLevel = 825;    // eBay API version

    if ($production) {
        $devID = 'Production_devID';   // these prod keys are different from sandbox keys
        $appID = 'Production_appID';
        $certID = 'Production_certID';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'Production_usertoken';
        $paypalEmailAddress= 'PAYPAL_EMAIL_ADDRESS';
    }
    else
    {
        $devID = 'c2559cd8-6041-49a8-ba41-cc9f3b4f70ea';         // insert your devID for sandbox
        $appID = 'Projectd-testing-SBX-b09141381-20dd8d91';   // different from prod keys
        $certID = 'SBX-0902ebf9dad6-c942-4e51-89d2-9575';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';

        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**f8n9WA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GlDpiLpQ2dj6x9nY+seQ**9ioEAA**AAMAAA**vwPKMWIVJs6JHzS0suYi+UxD1fkLDDjwbLgDJyh4NHy71yNjvu/ZMZR3o0NnJ5lS5smdt9WKz9HhVYwl6WAG39dS4nlRGHzSU9Ory2AeWFVXlzCdilj4qXEqquVwBVR4uWUZh2K04IR4pkaM+hNQDEqbi1Z++wfY/GQRUXQqqzlR04dUhrUHUhh5glwCAPdQJ2nMQ14YUqPwVEFttAXL4cQOFK2hsCZfQ1oQgnriq/ht3BRtxUtk4etaLxe1CQ5TbCUwIEVXELrOg4JZYegy+Z0zPb0pHqYeOMYB82yajqV0DfkRCeUJbuFNfRs+SSyTLUE24985nUerP0hlQRdaVtyDND8Qh/Mkslp5YrFG9LIxDzirrLzHnrQFcWb0xMvALp1Ri8iEEn/8mBh+nlFv7Jpsfdu8tx9aDGcmwO9Fg1nWWLPoMJhyMsx67zyR5QtcWLslvkc+3i/HP7Rt6AdmF6fyWMUjEVMOY6C1jmAZ7xGRB1a1IvC3pzWP5B6tEvwI8PUbm1wdEbK1SnEn/tvKvtg6L5fCwujINsutw5PlsBc5Btx09/FNYH7RAVTEwUk/m4e+SVMjc3y9273Pqhc3/XWkDS4i3q/ekWVY6+CreXwizDDcAt6rwQSIzoyUOcI44Gh+W6CTOoiN5UEuoMwjPtGrOeD2GcURv8PDGUZrCfOxObe/aRyb/uWbnrlCHFsfCwjcR1fidKxxXtprZfj4jHlWc+mYeiHcPZg0o9z534oR6iDhKDq4N1Mli4IVtq3f';
//        $userToken = 'v^1.1#i^1#r^0#p^3#I^3#f^0#t^H4sIAAAAAAAAAOVXa2wUVRTu9oW1FAMaLEZkHdSIZHbvzM4+Zuwu2dLWFvpY2BZok6a5O3OnjMzOrHNn2k6CWGosaZQQSKMBE2wUNSoEfOArNCGYCCEgaBASjCEqiv7AJvyoEonxzvbBtsTSBzFN3D+799zz+s75zt17QWd+wRPdld1/FLnmZPd1gs5sl4spBAX5ecvn5WQ/kJcFMhRcfZ2PdOZ25fxagmFSTQlrEU7pGkbujqSqYSEtDFOWoQk6xAoWNJhEWDBFIR6tqRZYDxBShm7qoq5S7qqyMCWHfIGgJLI+FIA8YiQi1UZ81uthSpQDEmIBJ/slPsCk9zG2UJWGTaiZYYoFTJAGHM1y9YAXOFZggx4QBE2Uex0ysKJrRMUDqEg6XSFta2TkOnGqEGNkmMQJFamKVsTrolVl5bX1Jd4MX5HhOsRNaFp47GqlLiH3OqhaaOIwOK0txC1RRBhT3shQhLFOhehIMtNIP13qYIj3+zg/L/EhHvCyeEdKWaEbSWhOnIcjUSRaTqsKSDMV075dRUk1Ek8j0Rxe1RIXVWVu52uNBVVFVpARpspLo40N8fK1lDseixl6myIhyUHK+HxcIMRzDBUxESYlREYLoZ3jbzjUkL/hQo+LtVLXJMUpG3bX6mYpInmj8dXxZVSHKNVpdUZUNp2cMvQYZqSK/lCT09ahPlrmRs3pLEqSUrjTy9v3YIQUN2lwp2gR8ItcMABDshSQgcwGxtHCmfVpUSPidCcai3lRAtp0EhqbkJlSoYhokZTWSiJDkQSOS3ABKMq0jw2JNCf5RZrn/YhmUQAFWOjjgMz9v9hhmoaSsEw0ypDxG2mYYSou6ikU01VFtKnxKukzZ5gPHThMbTTNlOD1tre3e9p9Ht1o9bIAMN4NNdVxcSNKQmpUV7m9Mq2kmSEiYoUVwbRTJJsOQjwSXGulIj5DikHDtEstm6zjSFXJ1wh5x2QYGS/9F6jYgTq7QDr2mDiAKcXj8Nsj6kmvDsksO6KWdMbuySh5E5ZN4kvI8BgISrqm2pO3a7UIf4esJ2eESTc8Q6NIYNwS0Zn1qTiYQlBFayNc1g17ijDHGk/BBoqibmnmdMINm07BQrZUWVFVZ1ynEzDDfCppalC1TUXEoyFnNGXRVKpKml1TFhs6lSXaOaeJhI6XbqATgGc4xhdiaBZIUkjimRnBllCbIqIWZZZB1yxVnRGumtaJIZFZ3/Pfw6r1RmeEqgy1zTaSiqzfz4tSiA4AjqE5HoboBCS/RJGXfQlODgIEZ4R5paqQg6Henm3/gZU6NpE0M2jkIjq7QDknzMgBw3Csn074+BDNiaEgzTMyQ0NeBpOFPE6QcaO75SrvHfuajmSlP0yXqx90uT4jD3JymaSZ5WBZfk5Dbs5cCism8mCoSQm9w6NA2YOVVo08Fg3k2YTsFFSM7HxXzU8vNT6X8Y7vawbFoy/5ghymMONZDx68uZPH3HN/ERMEHMsBnmPZYBNYenM3l1mYe19LP6V1935w6JWFx5tvLF7z6qXTT+0BRaNKLldeVm6XK+uu02X7zEvfeL7K1msW1RwH+JOejkfLWhq6z37+7f5tZ1+gK1e8VRjr7y+vLPkxntiyq/3A4JXBYzcOHm9YFhpcdWoRhc8sSNy7fn7z7suvnWxxs8feaS6ZXzBQOPfimgU93qKG31e/bl89qG1/ecX54of+emxeeePmM7+9tzb29YEjf58rPrxl65y9hxNbK35ZbC5ZdX53z5/MwevPuO++NnD0o20fd24v77M+rb54/YfLJ05dO/L9Vfvxh9/++YvuQPFg3Wo+u/rdfTv2g2ubn38WXNxb0dvYsT+568Te8nMDxtI3O17s2SbCyjmnNq3emb9+CQMvHN3RdOXJ3sXfvf+l7v3QPtl76EL0jbMDB4ba+A+H7xOWYREAAA==';
        $paypalEmailAddress = '';
//        $paypalEmailAddress = 'Project_desk-Projectd-testin-tmjaggzu';
    }
?>
