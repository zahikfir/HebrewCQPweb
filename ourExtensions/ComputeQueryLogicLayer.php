<script>

	var MaxTargetWords = 4;											// Defines: max number of words the user can search for
	var g_iCurrentTargetWordIndex = 0; 								// Index of word that the user is currently editing
	var g_aTargetWordsArr = new Array(MaxTargetWords);   			// Arr: the target-words the user is searching for
	var g_aMinWordsBetweenTargets = new Array(MaxTargetWords-1); 	// Arr: Min number of words between target-words (there are X-1 spaces between X words)
	var g_aMaxWordsBetweenTargets = new Array(MaxTargetWords-1);	// Arr: Max number of words between target-words (there are X-1 spaces between X words)

	
	// main function for the Compute Query GUI menu, called when the "Compute Query" button is pushed 
	// translates the Query menu and save the result into the global variables
	// reset the menu and write the new query into the main query textbox
	function ComputeQuery()
	{
		// check global variables aren't null 
		if( !(g_aMaxWordsBetweenTargets && g_aMaxWordsBetweenTargets && g_aTargetWordsArr) )
			alert("Sorry Somthing Is wrong with ComputeQuery()");
		else
		{				
			UpdateMinMaxWordsBetweenTargets();
			TranslateComputeQueryGUI();
			WriteQuery();
			ResetDropListsMenu();

			//var myTextField2 = document.getElementById('QueryTextbox');
			//myTextField2.value += " Hello world! " + myTextField.value;
		}
	}

	// update global variable arrays with the max/min words between target-words
	// arr[0] between targets 1-2, arr[1] between targets 2-3, arr[2] between targets 3-4, 
	function UpdateMinMaxWordsBetweenTargets()
	{
		// update the min/max word between first-second target-words
		var TempTextBox = document.getElementById('MinWordsBetweenTargets[1-2]TextBox');
		if(TempTextBox.value)
			g_aMinWordsBetweenTargets[0] = parseInt(TempTextBox.value,10);
		else
			g_aMinWordsBetweenTargets[0] = null;
		TempTextBox = document.getElementById('MaxWordsBetweenTargets[1-2]TextBox');
		if(TempTextBox.value)
			g_aMaxWordsBetweenTargets[0] = parseInt(TempTextBox.value,10);
		else
			g_aMaxWordsBetweenTargets[0] = null;

		// update the min/max word between second-third target-words
		TempTextBox = document.getElementById('MinWordsBetweenTargets[2-3]TextBox');
		if(TempTextBox.value)
			g_aMinWordsBetweenTargets[1] = parseInt(TempTextBox.value,10);
		else
			g_aMinWordsBetweenTargets[1] = null;
		TempTextBox = document.getElementById('MaxWordsBetweenTargets[2-3]TextBox');
		if(TempTextBox.value)
			g_aMaxWordsBetweenTargets[1] = parseInt(TempTextBox.value,10);
		else
			g_aMaxWordsBetweenTargets[1] = null;

		// update the min/max word between third-fourth target-words
		TempTextBox = document.getElementById('MinWordsBetweenTargets[3-4]TextBox');
		if(TempTextBox.value)
			g_aMinWordsBetweenTargets[2] = parseInt(TempTextBox.value,10);
		else
			g_aMinWordsBetweenTargets[2] = null;
		TempTextBox = document.getElementById('MaxWordsBetweenTargets[3-4]TextBox');
		if(TempTextBox.value)
			g_aMaxWordsBetweenTargets[2] = parseInt(TempTextBox.value,10);
		else
			g_aMaxWordsBetweenTargets[2] = null;
	}

	// writing the query into the main query textbox 
	// writing each target word into it single-target-word textboxes
	function WriteQuery()
	{
		ClearQueryTextboxes();
		WriteMainQuery();
		WriteSingleTargetWord();
	}

	// writing the query into the main query textbox 
	function WriteMainQuery()
	{
		var pQueryTextbox = document.getElementById('QueryTextbox');

		// for each target-word
		for(var ii=0;ii<MaxTargetWords;ii++)
		{	
			// write the target-word if exists 	
			if(g_aTargetWordsArr[ii])
				pQueryTextbox.value += ("[" + g_aTargetWordsArr[ii] + "] ");

			// print the min&max word between target-words if exists	
			if(ii <MaxTargetWords-1) 	// (there are X-1 spaces between X words)
			{
				if(g_aMinWordsBetweenTargets[ii] || g_aMaxWordsBetweenTargets[ii])
				{
					pQueryTextbox.value += "[]{";
					if(g_aMinWordsBetweenTargets[ii])
						pQueryTextbox.value += g_aMinWordsBetweenTargets[ii];
					else
						pQueryTextbox.value += 0; // CQP syntax: []{,5} ERROR   []{0,5} O.K   ( (!min)&(Max) )->(min = 0)
					pQueryTextbox.value += ",";
					if(g_aMaxWordsBetweenTargets[ii])
						pQueryTextbox.value += g_aMaxWordsBetweenTargets[ii];
					pQueryTextbox.value += "} ";	
				}
			}
		}
	}

	// writing each target word into it single-target-word textboxes
	function WriteSingleTargetWord()
	{
		var pQueryTextbox = document.getElementById('SingleTargetWord1Textbox');
		if(g_aTargetWordsArr[0])
			pQueryTextbox.value += ("[" + g_aTargetWordsArr[0] + "] ");

		pQueryTextbox = document.getElementById('SingleTargetWord2Textbox');
		if(g_aTargetWordsArr[1])
			pQueryTextbox.value += ("[" + g_aTargetWordsArr[1] + "] ");

		pQueryTextbox = document.getElementById('SingleTargetWord3Textbox');
		if(g_aTargetWordsArr[2])
			pQueryTextbox.value += ("[" + g_aTargetWordsArr[2] + "] ");

		pQueryTextbox = document.getElementById('SingleTargetWord4Textbox');
		if(g_aTargetWordsArr[3])
			pQueryTextbox.value += ("[" + g_aTargetWordsArr[3] + "] ");	
	}
	
	// change the current word index to input value, called by the switch word buttons
	// only current word changing when translating the query GUI. 
	function ChangeCurrentWord(iCurrentWord)
	{
		g_iCurrentTargetWordIndex = parseInt(iCurrentWord,10); // parsing to int, '10' - decimal base 
	}

	// clear the main query text box
	// clear the single target word textboxes
	function ClearQueryTextboxes()
	{
		var pQueryTextbox = document.getElementById('QueryTextbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord1Textbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord2Textbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord3Textbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord4Textbox');
		pQueryTextbox.value = "";	
	}

	// clear target-word array, max/min word between target-words arrayes, query compute GUI
	function ClearAll()
	{
		for(var ii=0;ii<MaxTargetWords;ii++) 
		{ 
			g_aTargetWordsArr[ii] = null; 
		}
		for(var ii=0;ii<(MaxTargetWords-1);ii++)
		{	
			g_aMinWordsBetweenTargets[ii] = null;
			g_aMaxWordsBetweenTargets[ii] = null;
		}
		ClearMinMaxWordsBetweenTargetsTextBox(0);
		ClearMinMaxWordsBetweenTargetsTextBox(1);
		ClearMinMaxWordsBetweenTargetsTextBox(2);
		ResetDropListsMenu();
		WriteQuery();
	}

	// clear current target-word, max/min word between current target-word, query compute GUI
	function ClearCurrnet(Index)
	{
		g_aTargetWordsArr[Index] = null;

		// clear max/min word between current target-word and the target-word before
		// clear the min/max ... textbox accordingly
		if(Index-1 >=0)
		{
			g_aMinWordsBetweenTargets[Index-1] = null;
			g_aMaxWordsBetweenTargets[Index-1] = null;
			ClearMinMaxWordsBetweenTargetsTextBox(Index-1);
		}

		// clear max/min word between current target-word and the target-word after
		// clear the min/max ... textbox accordingly
		if(Index < MaxTargetWords-1)
		{
			g_aMinWordsBetweenTargets[Index] = null;
			g_aMaxWordsBetweenTargets[Index] = null;
			ClearMinMaxWordsBetweenTargetsTextBox(Index);
		}
		ResetDropListsMenu();
		WriteQuery();	
	}

	// clear the textboxes for the min/max words between target-words
	// input 0:between first-second, 1:between second-third, 2:between third-fourth 
	function ClearMinMaxWordsBetweenTargetsTextBox(iIndex)
	{		
		switch(iIndex)
		{
		case 0:
			var TempTextBox = document.getElementById('MinWordsBetweenTargets[1-2]TextBox');
			TempTextBox.value = null;
			TempTextBox = document.getElementById('MaxWordsBetweenTargets[1-2]TextBox');
			TempTextBox.value = null;
			break;
		case 1:
			var TempTextBox = document.getElementById('MinWordsBetweenTargets[2-3]TextBox');
			TempTextBox.value = null;
			TempTextBox = document.getElementById('MaxWordsBetweenTargets[2-3]TextBox');
			TempTextBox.value = null;
			break;
		case 2:
			var TempTextBox = document.getElementById('MinWordsBetweenTargets[3-4]TextBox');
			TempTextBox.value = null;
			TempTextBox = document.getElementById('MaxWordsBetweenTargets[3-4]TextBox');
			TempTextBox.value = null;
			break;
		default:
			alert("Somthing is Wrong in ClearMinMaxWordsBetweenTargetsTextBox() ");
			break;	
		}
	}

	// appanding open bracket '(' to current word
	// writing the query again at the end, so the user can see the effect immediately
	function AppendOpenBracket() 
	{ 
		if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] += "(";
		else
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] = "(";
		WriteQuery();
	}

	// appanding close bracket ')' to current word
	// writing the query again at the end, so the user can see the effect immediately
	function AppandCloseBracket()
	{ 
		if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] += ")";
		else
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] = ")";
		WriteQuery();
	} 

	// appanding the operator Or '|' to current word
	// writing the query again at the end, so the user can see the effect immediately
	function AppandOperatorOr()
	{ 
		if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] += " | ";
		else
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] = " | ";
		WriteQuery();
	} 

	// appanding the operator and '&' to current word
	// writing the query again at the end, so the user can see the effect immediately 
	function AppandOperatorAnd()
	{ 
		if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] += " & ";
		else
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] = " & ";
		WriteQuery();
	} 
	/**************************** the below is undocumented  ********************************/	
	function TranslateComputeQueryGUI()
	{
		var FullQuery = null;

		var TempQuery = GetTargetWord();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = GetPrefix1();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = GetPrefix2();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = GetPrefix3();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = GetPrefix4();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = GetPrefix5();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = GetPrefix6();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		var TempQuery = Getbase();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		if(FullQuery)
		{
			FullQuery += ")";
			if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
				g_aTargetWordsArr[g_iCurrentTargetWordIndex] += FullQuery;
			else
				g_aTargetWordsArr[g_iCurrentTargetWordIndex] = FullQuery;
		}		
	}

	/**************************** the ablove is undocumented  ********************************/	
	
	// read the target word from texbox and return it in CQP syntax
	function GetTargetWord()
	{
		var ReturnValue = null;

		var TempTextBox = document.getElementById('TargetWordTextbox');
		if(TempTextBox.value)
			ReturnValue = "word=\"" + TempTextBox.value + "\"";

		return ReturnValue;	
	}

	// read base from DropList and return it in CQP syntax
	function Getbase()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "base=\"";

		var TempDropList = document.getElementById('BaseBaseType');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseGender');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseNumber');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char		 		 

		TempDropList = document.getElementById('BaseStatus');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseDefiniteness');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseForeign');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseRegister');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char


		TempDropList = document.getElementById('BaseSpelling');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BasePerson');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char


		TempDropList = document.getElementById('BaseTense');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseBinyan');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BasePolarity');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		TempDropList = document.getElementById('BaseMultiWordPrefix');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char
					
		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}
	
	// read prefix1 from DropList and return it in CQP syntax
	function GetPrefix1()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "prefix1=\"";

		var TempDropList = document.getElementById('prefix1surface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('prefix1function');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('prefix1multiword');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}

	// read prefix2 from DropList and return it in CQP syntax
	function GetPrefix2()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "prefix2=\"";

		var TempDropList = document.getElementById('prefix2surface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('prefix2function');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('prefix2multiword');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}

	// read prefix3 from DropList and return it in CQP syntax
	function GetPrefix3()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "prefix3=\"";

		var TempDropList = document.getElementById('prefix3surface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('prefix3function');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('prefix3multiword');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}

	// read prefix4 from DropList and return it in CQP syntax
	function GetPrefix4()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "prefix4=\"";

		var TempDropList = document.getElementById('prefix4surface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('prefix4function');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('prefix4multiword');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}

	// read prefix5 from DropList and return it in CQP syntax
	function GetPrefix5()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "prefix5=\"";

		var TempDropList = document.getElementById('prefix5surface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('prefix5function');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('prefix5multiword');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}

	// read prefix1 from DropList and return it in CQP syntax
	function GetPrefix6()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "prefix6=\"";

		var TempDropList = document.getElementById('prefix6surface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('prefix6function');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('prefix6multiword');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		ReturnValue += "\"";
		if(bOneFlagIsOn == false)
			ReturnValue = null;		// if all flags are off, (all dropLists are empty) return null

		return ReturnValue;
	}
	
	// reset al the drop down list menus 
	// 'N' is the value of the empty option in the DropList menu
	function ResetDropListsMenu()
	{
		// reset the target-word textbox
		var TempDropList = document.getElementById('TargetWordTextbox');
		TempDropList.value = null;

		// reset the prefix1 menu
		TempDropList = document.getElementById('prefix1surface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix1function');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix1multiword');
		TempDropList.value = 'N';

		// reset the prefix2 menu
		TempDropList = document.getElementById('prefix2surface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix2function');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix2multiword');
		TempDropList.value = 'N';

		// reset the prefix3 menu
		TempDropList = document.getElementById('prefix3surface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix3function');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix3multiword');
		TempDropList.value = 'N';

		// reset the prefix4 menu
		TempDropList = document.getElementById('prefix4surface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix4function');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix4multiword');
		TempDropList.value = 'N';

		// reset the prefix5 menu 
		TempDropList = document.getElementById('prefix5surface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix5function');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix5multiword');
		TempDropList.value = 'N';

		// reset the prefix6 menu
		TempDropList = document.getElementById('prefix6surface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix6function');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('prefix6multiword');
		TempDropList.value = 'N';

		// reset the Base menu
		TempDropList = document.getElementById('BaseBaseType');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseGender');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseNumber');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseStatus');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseDefiniteness');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseForeign');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseRegister');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseSpelling');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BasePerson');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseTense');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseBinyan');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BasePolarity');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('BaseMultiWordPrefix');
		TempDropList.value = 'N';

		// reset the sufix menu
		TempDropList = document.getElementById('sufixSurface');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('sufixFunction');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('sufixPerson');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('sufixGender');
		TempDropList.value = 'N';
		TempDropList = document.getElementById('sufixNumber');
		TempDropList.value = 'N';
	} 

	// combined with <input type='text' onkeypress="return isNumberKey(event)"/> 
	// creates textbox that allows only number to be writen into it
	function isNumberKey(evt)
    {
       var charCode = (evt.which) ? evt.which : event.keyCode;
       if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
       return true;
    }
</script>
