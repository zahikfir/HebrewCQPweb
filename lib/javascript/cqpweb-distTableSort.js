/**
 * CQPweb: a user-friendly interface to the IMS Corpus Query Processor
 * Copyright (C) 2008-10 Andrew Hardie
 *
 * See http://www.ling.lancs.ac.uk/activities/713/
 *
 * This file is part of CQPweb.
 * 
 * CQPweb is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * 
 * CQPweb is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



function distTableSort(link, type)
{

	var table = link.parentNode.parentNode.parentNode;
	var toprow = link.parentNode.parentNode;
	
	var sort_function = distTableSort_catorder;
	
	if (type == "freq")
	{
		sort_function = distTableSort_freqorder;
		table = table.parentNode;
		toprow = toprow.parentNode
	}	

	var newRows = new Array();
	var index_of_toprow = -1;
	var bottomrow;
	
	for (var i = 1 ; i < table.rows.length ; i++)
	{
		if (table.rows[i] == toprow)
		{
			index_of_toprow = i;	
			break;
		}
	}
	
	for (var j = index_of_toprow +1 ; j < table.rows.length ; j++)
	{
		if (table.rows[j].cells[0].className == "concordgrey")
		{
			bottomrow = table.rows[j];
			break;
		}
		newRows.push(table.rows[j]);
	}

	newRows.sort(sort_function);
	
	for (var k = 0; k < newRows.length; k++)
	{
		table.insertBefore(newRows[k], bottomrow);
	}
}

function distTableSort_freqorder(a,b)
{
	if (parseFloat(a.cells[4].innerHTML) < parseFloat(b.cells[4].innerHTML) ) 
		{ return 1; }
	if (parseFloat(a.cells[4].innerHTML) > parseFloat(b.cells[4].innerHTML) ) 
		{ return -1; }
	return 0;
}

function distTableSort_catorder(a,b)
{
	if (a.cells[0].id.toLowerCase().trim() < b.cells[0].innerHTML.toLowerCase().trim() ) 
		{ return -1; }
	if (a.cells[0].id.toLowerCase().trim() > b.cells[0].innerHTML.toLowerCase().trim() ) 
		{ return 1; }
	return 0;
}