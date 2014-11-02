/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showreport()
{
	PopulateForm(document.retireform);
	var winheight = 500;
	var winwidth = 655;
	var newwin = window.open('', 'printable', 'height=' + winheight + ',width=' + winwidth + ',toolbar,scrollbars,resizable');
	
	var styles = '<LINK REL="stylesheet" TYPE="text/css"'
		+ 'HREF="http://www.bloomberg.com/stylesheets/main-min.css" />'
		+ '<link href="/stylesheets/blocks.css"'
		+ ' media="all" rel="stylesheet" type="text/css" />';
	var head = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'
	      	+ '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'
			+ '<html xmlns="http://www.w3.org/1999/xhtml"' 
			+ 'xmlns:og="http://opengraphprotocol.org/schema/">'
			+ '<html><head><title>Retirement Bloomberg</title>' + styles 
			+ '</head><body class="calculator_popup">';
	var header = '<div class="calc_title align_center" align="center">Retirement Calculator</div>';
		
	var footer = '<p class="footer">&copy;' + new Date().getFullYear() + ' Bloomberg L.P. All rights reserved.</p>';
	var tail = '</body></html>';
	newwin.document.write(head);
	newwin.document.write(header);
	newwin.document.write(rcalc.retireTable());
	newwin.document.write(footer);
	newwin.document.write(tail);
	newwin.document.close();
	newwin.focus();

}