<?php

/**
 * webconfig Helper
 * @author      Danny Nunez 300development@gmail.com
 */

class WebConfig 
{

    /**
     * @Description - Provide a multi-demensional array to parse and create a web.config file. The base settings are from  the web.config examples at https://github.com/h5bp/server-configs 
     * @param Array - Mulit-Demensional $paths
     * EXAMPLE: 
     *                              Old URL                                               New URL
     * $redirects array = ('orgUrl' => 'http://example.com/oldurl' , 'redirect' => 'http://example.com/newurl' ); 
     * 
     */
    public function create($paths)
    {
        $webConfig = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><configuration></configuration>');
        // add 404 http error block
        // start   <system.webServer>
        $_404 = $webConfig->addChild('system.webServer');
        $error_mode = $_404->addChild('httpErrors');
        $error_mode->addAttribute('errorMode', 'Custom');
        $error_mode->addAttribute('existingResponse', 'Replace');
        $remove = $error_mode->addChild('remove');
        $remove->addAttribute('statusCode', '404');
        $remove->addAttribute('subStatusCode', '-1');
        $error = $error_mode->addChild('error');
        $error->addAttribute('statusCode', '404');
        $error->addAttribute('prefixLanguageFilePath', '');
        $error->addAttribute('path', '/404.php');
        $error->addAttribute('responseMode', 'ExecuteURL');
        // add url rewrite to remove index.php
        $rewrite = $_404->addChild('rewrite');
        $rules = $rewrite->addChild('rules');
        $rule = $rules->addChild('rule');
        $rule->addAttribute('name', 'Imported Rule 1');
        $rule->addAttribute('stopProcessing', 'true');
        $match = $rule->addChild('match');
        $match->addAttribute('url', '^(.*)$');
        $match->addAttribute('ignoreCase', 'false');
        $conditions = $rule->addChild('conditions');
        $conditions->addAttribute('logicalGrouping', 'MatchAll');
        $add1 = $conditions->addChild('add');
        $add1->addAttribute('input', '{REQUEST_FILENAME}');
        $add1->addAttribute('matchType', 'IsFile');
        $add1->addAttribute('ignoreCase', 'false');
        $add1->addAttribute('negate', 'true');
        $add2 = $conditions->addChild('add');
        $add2->addAttribute('input', '{REQUEST_FILENAME}');
        $add2->addAttribute('matchType', 'IsDirectory');
        $add2->addAttribute('ignoreCase', 'false');
        $add2->addAttribute('negate', 'true');
        $action = $rule->addChild('action');
        $action->addAttribute('type', 'Rewrite');
        $action->addAttribute('url', 'index.php/{R:1}');
        // http compression
        $httpCompression = $_404->addChild('httpCompression');
        $httpCompression->addAttribute('directory', '%SystemDrive%\inetpub\temp\IIS Temporary Compressed Files');
        $scheme = $httpCompression->addChild('scheme');
        $scheme->addAttribute('name', 'gzip');
        $scheme->addAttribute('dll', '%Windir%\system32\inetsrv\gzip.dll');
        // DynamicTypes
        unset($add1, $add2);
        $dynamicTypes = $httpCompression->addChild('dynamicTypes');
        $add1 = $dynamicTypes->addChild('add');
        $add1->addAttribute('mimeType', 'text/*');
        $add1->addAttribute('enabled', 'true');
        $add2 = $dynamicTypes->addChild('add');
        $add2->addAttribute('mimeType', 'gzip');
        $add2->addAttribute('enabled', 'true');
        $add3 = $dynamicTypes->addChild('add');
        $add3->addAttribute('mimeType', 'application/javascript');
        $add3->addAttribute('enabled', 'true');
        $add4 = $dynamicTypes->addChild('add');
        $add4->addAttribute('mimeType', '*/*');
        $add4->addAttribute('enabled', 'true');
        // Static Types
        unset($add1, $add2, $add3, $add4);
        $staticTypes = $httpCompression->addChild('staticTypes');
        $add1 = $staticTypes->addChild('add');
        $add1->addAttribute('mimeType', 'text/*');
        $add1->addAttribute('enabled', 'true');
        $add2 = $dynamicTypes->addChild('add');
        $add2->addAttribute('mimeType', 'gzip');
        $add2->addAttribute('enabled', 'true');
        $add3 = $dynamicTypes->addChild('add');
        $add3->addAttribute('mimeType', 'application/javascript');
        $add3->addAttribute('enabled', 'true');
        $add4 = $dynamicTypes->addChild('add');
        $add4->addAttribute('mimeType', '*/*');
        $add4->addAttribute('enabled', 'true');
        // url compression
        $urlCompression = $_404->addChild('urlCompression');
        $urlCompression->addAttribute('doStaticCompression', 'true');
        $urlCompression->addAttribute('doDynamicCompression', 'true');
        // Static content
        $staticContent = $_404->addChild('staticContent');
        $clientCache = $staticContent->addChild('clientCache');
        $clientCache->addAttribute('cacheControlMode', 'UseMaxAge');
        $clientCache->addAttribute('cacheControlMaxAge', '30.00:00:00');
        // css
        $RemoveExt_css = $staticContent->addChild('remove');
        $RemoveExt_css->addAttribute('fileExtension', '.css');
        $mimeMap_css = $staticContent->addChild('mimeMap');
        $mimeMap_css->addAttribute('fileExtension', '.css');
        $mimeMap_css->addAttribute('mimeType', 'text/css');
        // js
        $RemoveExt_js = $staticContent->addChild('remove');
        $RemoveExt_js->addAttribute('fileExtension', '.js');
        $mimeMap_js = $staticContent->addChild('mimeMap');
        $mimeMap_js->addAttribute('fileExtension', '.js');
        $mimeMap_js->addAttribute('mimeType', 'text/javascript');
        // json
        $RemoveExt_json = $staticContent->addChild('remove');
        $RemoveExt_json->addAttribute('fileExtension', '.json');
        $mimeMap_json = $staticContent->addChild('mimeMap');
        $mimeMap_json->addAttribute('fileExtension', '.json');
        $mimeMap_json->addAttribute('mimeType', 'application/json');
        // rss
        $RemoveExt_rss = $staticContent->addChild('remove');
        $RemoveExt_rss->addAttribute('fileExtension', '.rss');
        $mimeMap_rss = $staticContent->addChild('mimeMap');
        $mimeMap_rss->addAttribute('fileExtension', '.rss');
        $mimeMap_rss->addAttribute('mimeType', 'application/xml; charset=UTF-8');

        // HTML5 Audio/Video mime types
        // mp3
        $RemoveExt_mp3 = $staticContent->addChild('remove');
        $RemoveExt_mp3->addAttribute('fileExtension', '.mp3');
        $mimeMap_mp3 = $staticContent->addChild('mimeMap');
        $mimeMap_mp3->addAttribute('fileExtension', '.mp3');
        $mimeMap_mp3->addAttribute('mimeType', 'audio/mpeg');
        // mp3
        $RemoveExt_mp3 = $staticContent->addChild('remove');
        $RemoveExt_mp3->addAttribute('fileExtension', '.mp3');
        $mimeMap_mp3 = $staticContent->addChild('mimeMap');
        $mimeMap_mp3->addAttribute('fileExtension', '.mp3');
        $mimeMap_mp3->addAttribute('mimeType', 'audio/mpeg');
        // mp4
        $RemoveExt_mp4 = $staticContent->addChild('remove');
        $RemoveExt_mp4->addAttribute('fileExtension', '.mp4');
        $mimeMap_mp4 = $staticContent->addChild('mimeMap');
        $mimeMap_mp4->addAttribute('fileExtension', '.mp4');
        $mimeMap_mp4->addAttribute('mimeType', 'video/mp4');
        // ogg
        $RemoveExt_ogg = $staticContent->addChild('remove');
        $RemoveExt_ogg->addAttribute('fileExtension', '.ogg');
        $mimeMap_ogg = $staticContent->addChild('mimeMap');
        $mimeMap_ogg->addAttribute('fileExtension', '.ogg');
        $mimeMap_ogg->addAttribute('mimeType', 'audio/ogg');
        // ogv
        $RemoveExt_ogv = $staticContent->addChild('remove');
        $RemoveExt_ogv->addAttribute('fileExtension', '.ogv');
        $mimeMap_ogv = $staticContent->addChild('mimeMap');
        $mimeMap_ogv->addAttribute('fileExtension', '.ogv');
        $mimeMap_ogv->addAttribute('mimeType', 'video/ogg');
        // webm
        $RemoveExt_webm = $staticContent->addChild('remove');
        $RemoveExt_webm->addAttribute('fileExtension', '.webm');
        $mimeMap_webm = $staticContent->addChild('mimeMap');
        $mimeMap_webm->addAttribute('fileExtension', '.webm');
        $mimeMap_webm->addAttribute('mimeType', 'video/webm');
        //  Proper svg serving. Required for svg webfonts on iPad
        // svg
        $RemoveExt_svg = $staticContent->addChild('remove');
        $RemoveExt_svg->addAttribute('fileExtension', '.svg');
        $mimeMap_svg = $staticContent->addChild('mimeMap');
        $mimeMap_svg->addAttribute('fileExtension', '.svg');
        $mimeMap_svg->addAttribute('mimeType', 'image/svg+xml');
        //svgz
        $RemoveExt_svgz = $staticContent->addChild('remove');
        $RemoveExt_svgz->addAttribute('fileExtension', '.svgz');
        $mimeMap_svgz = $staticContent->addChild('mimeMap');
        $mimeMap_svgz->addAttribute('fileExtension', '.svgz');
        $mimeMap_svgz->addAttribute('mimeType', 'image/svg+xml');
        // HTML4 Web font mime types
        // eot
        $RemoveExt_eot = $staticContent->addChild('remove');
        $RemoveExt_eot->addAttribute('fileExtension', '.eot');
        $mimeMap_eot = $staticContent->addChild('mimeMap');
        $mimeMap_eot->addAttribute('fileExtension', '.eot');
        $mimeMap_eot->addAttribute('mimeType', 'application/vnd.ms-fontobject');
        // ttf
        $RemoveExt_ttf = $staticContent->addChild('remove');
        $RemoveExt_ttf->addAttribute('fileExtension', '.ttf');
        $mimeMap_ttf = $staticContent->addChild('mimeMap');
        $mimeMap_ttf->addAttribute('fileExtension', '.ttf');
        $mimeMap_ttf->addAttribute('mimeType', 'application/x-font-ttf');
        // ttc
        $RemoveExt_ttc = $staticContent->addChild('remove');
        $RemoveExt_ttc->addAttribute('fileExtension', '.ttc');
        $mimeMap_ttc = $staticContent->addChild('mimeMap');
        $mimeMap_ttc->addAttribute('fileExtension', '.ttc');
        $mimeMap_ttc->addAttribute('mimeType', 'application/x-font-ttf');
        // otf
        $RemoveExt_otf = $staticContent->addChild('remove');
        $RemoveExt_otf->addAttribute('fileExtension', '.otf');
        $mimeMap_otf = $staticContent->addChild('mimeMap');
        $mimeMap_otf->addAttribute('fileExtension', '.otf');
        $mimeMap_otf->addAttribute('mimeType', 'font/opentype');
        // woff
        $RemoveExt_wotf = $staticContent->addChild('remove');
        $RemoveExt_wotf->addAttribute('fileExtension', '.woff');
        $mimeMap_wotf = $staticContent->addChild('mimeMap');
        $mimeMap_wotf->addAttribute('fileExtension', '.woff');
        $mimeMap_wotf->addAttribute('mimeType', 'application/font-woff');
        // crx
        $RemoveExt_crx = $staticContent->addChild('remove');
        $RemoveExt_crx->addAttribute('fileExtension', '.crx');
        $mimeMap_crx = $staticContent->addChild('mimeMap');
        $mimeMap_crx->addAttribute('fileExtension', '.crx');
        $mimeMap_crx->addAttribute('mimeType', 'application/x-chrome-extension');
        // xpi
        $RemoveExt_xpi = $staticContent->addChild('remove');
        $RemoveExt_xpi->addAttribute('fileExtension', '.xpi');
        $mimeMap_xpi = $staticContent->addChild('mimeMap');
        $mimeMap_xpi->addAttribute('fileExtension', '.xpi');
        $mimeMap_xpi->addAttribute('mimeType', 'application/x-xpinstall');
        // xpi
        $RemoveExt_xpi = $staticContent->addChild('remove');
        $RemoveExt_xpi->addAttribute('fileExtension', '.xpi');
        $mimeMap_xpi = $staticContent->addChild('mimeMap');
        $mimeMap_xpi->addAttribute('fileExtension', '.xpi');
        $mimeMap_xpi->addAttribute('mimeType', 'application/x-xpinstall');
        // safariextz
        $RemoveExt_safariextz = $staticContent->addChild('remove');
        $RemoveExt_safariextz->addAttribute('fileExtension', '.safariextz');
        $mimeMap_safariextz = $staticContent->addChild('mimeMap');
        $mimeMap_safariextz->addAttribute('fileExtension', '.safariextz');
        $mimeMap_safariextz->addAttribute('mimeType', 'application/octet-stream');
        // Flash Video mime types
        // flv
        $RemoveExt_flv = $staticContent->addChild('remove');
        $RemoveExt_flv->addAttribute('fileExtension', '.flv');
        $mimeMap_flv = $staticContent->addChild('mimeMap');
        $mimeMap_flv->addAttribute('fileExtension', '.flv');
        $mimeMap_flv->addAttribute('mimeType', 'video/x-flv');
        // fv4
        $RemoveExt_f4v = $staticContent->addChild('remove');
        $RemoveExt_f4v->addAttribute('fileExtension', '.f4v');
        $mimeMap_f4v = $staticContent->addChild('mimeMap');
        $mimeMap_f4v->addAttribute('fileExtension', '.f4v');
        $mimeMap_f4v->addAttribute('mimeType', 'video/mp4');
        // Asorted types
        // ico 
        $RemoveExt_ico = $staticContent->addChild('remove');
        $RemoveExt_ico->addAttribute('fileExtension', '.ico');
        $mimeMap_ico = $staticContent->addChild('mimeMap');
        $mimeMap_ico->addAttribute('fileExtension', '.ico');
        $mimeMap_ico->addAttribute('mimeType', 'image/x-icon');
        //webp
        $RemoveExt_webp = $staticContent->addChild('remove');
        $RemoveExt_webp->addAttribute('fileExtension', '.webp');
        $mimeMap_webp = $staticContent->addChild('mimeMap');
        $mimeMap_webp->addAttribute('fileExtension', '.webp');
        $mimeMap_webp->addAttribute('mimeType', 'image/webp');
        //appcache
        $RemoveExt_appcache = $staticContent->addChild('remove');
        $RemoveExt_appcache->addAttribute('fileExtension', '.appcache');
        $mimeMap_appcache = $staticContent->addChild('mimeMap');
        $mimeMap_appcache->addAttribute('fileExtension', '.appcache');
        $mimeMap_appcache->addAttribute('mimeType', 'text/cache-manifest');
        //appcache
        $RemoveExt_manifest = $staticContent->addChild('remove');
        $RemoveExt_manifest->addAttribute('fileExtension', '.manifest');
        $mimeMap_manifest = $staticContent->addChild('mimeMap');
        $mimeMap_manifest->addAttribute('fileExtension', '.manifest');
        $mimeMap_manifest->addAttribute('mimeType', 'text/cache-manifest');
        // htc
        $RemoveExt_htc = $staticContent->addChild('remove');
        $RemoveExt_htc->addAttribute('fileExtension', '.htc');
        $mimeMap_htc = $staticContent->addChild('mimeMap');
        $mimeMap_htc->addAttribute('fileExtension', '.htc');
        $mimeMap_htc->addAttribute('mimeType', 'text/x-component');
        // vcf
        $RemoveExt_vcf = $staticContent->addChild('remove');
        $RemoveExt_vcf->addAttribute('fileExtension', '.vcf');
        $mimeMap_vcf = $staticContent->addChild('mimeMap');
        $mimeMap_vcf->addAttribute('fileExtension', '.vcf');
        $mimeMap_vcf->addAttribute('mimeType', 'text/x-vcard');
        // end   </system.webServer> 
        // add 404 custom error block
        // start <system.web>
        $_404 = $webConfig->addChild('system.web');
        $error_mode = $_404->addChild('customErrors');
        $error_mode->addAttribute('mode', 'on');
        $error_mode->addAttribute('defaultRedirect', '/404.php');
        $remove = $error_mode->addChild('error');
        $remove->addAttribute('statusCode', '404');
        $remove->addAttribute('redirect', '/404.php');
        // end <system.web>
        // start all redirects
        //                            Old URL                                   New URL
        // Example $redirects array = ('orgUrl' => 'http://example.com/oldurl' , 'redirect' => 'http://example.com/newurl' ); 
        
        foreach ($redirects as $redirect) {
            $item = $webConfig->addChild('location');
            $item->addAttribute('path', $redirect['orgUrl']);
            $webServer = $item->addChild('system.webServer');
            $httpRedirect = $webServer->addChild('httpRedirect');
            $httpRedirect->addAttribute('enabled', 'true');
            $httpRedirect->addAttribute('destination', $redirect['redirect']);
            $httpRedirect->addAttribute('httpResponseStatus', 'Permanent');
        }

        $webConfig->asXML('web.config');
        return true; 
    }

}