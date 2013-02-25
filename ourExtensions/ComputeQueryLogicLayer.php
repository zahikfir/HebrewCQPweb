<!--                                          Compute Query Logic Layer:                                          -->
<!--                               handles all the logic behind the Compute query GUI                             -->

<!-- calles OnPageReaload() on page realod --> 
<!-- reset all Textboxes and DropLists, except main query textbox -->
<body onload="OnPageReaload()">



<!----------------------------------------------------------------------------------------------------->
<!------------------------------------- general functions and variables ------------------------------->
<!----------------------------------------------------------------------------------------------------->
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
			//ClearUserMenu();
		}
	}
	
	// called on page realod. reset all Textboxes and DropLists
	// NOT rest the main query textbox, in case the user pushed the back button in web browser.
	// allowing the user to go back and make changes to last query without the need to rewrite it again
	function OnPageReaload()
	{
		//ClearUserMenu();
		ClearSingleTargetTextboxes();
		ChangeCurrentWordButtonsEffect(0);	
		ClearMinMaxWordsBetweenTargetsTextBox(0);
		ClearMinMaxWordsBetweenTargetsTextBox(1);
		ClearMinMaxWordsBetweenTargetsTextBox(2);
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

	// gets: DropList ID (DropDownListID), option value (Value), option label (Label)
	// insert an option with Label and Value into the DropDownList with this ID
    function AddDropListOption(DropDownListId, Value, Label) {
		var DropDownList = document.getElementById(DropDownListId);
        var TempOption = document.createElement('option');
        TempOption.value = Value;
        TempOption.text = Label;
        DropDownList.options.add(TempOption);
    }

 	// gets DropList ID, clear all options in this DropList 
 	// inserts empty label option with value 'N'
 	function ClearAllDropListOptions(DropListId)
 	{ 
		document.getElementById(DropListId).options.length = 0;
		AddDropListOption(DropListId,'N',"");
 	}

 	// gets DropList ID, choose the empty option in this DropList
 	function ChooseDropListEmptyOption(DropListId)
 	{
 		var DropDownList = document.getElementById(DropListId);
 		DropDownList.value = 'N';
 	}

 	// gets Textbox ID, clear it
	function ClearTextBox(TextBoxID)
	{
 		var TempTextBox = document.getElementById(TextBoxID);
		TempTextBox.value = null;
	}
</script>


<!----------------------------------------------------------------------------------------------------->
<!------------------------------------------ Writing functions ---------------------------------------->
<!----------------------------------------------------------------------------------------------------->
<script>
	//writing the query into the main query textbox 
	// writing each target word into it single-target-word textboxes
	function WriteQuery()
	{
		ClearTextBox('QueryTextbox');
		ClearSingleTargetTextboxes();
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
</script>


<!----------------------------------------------------------------------------------------------------->
<!------------------------------ Clean/Delete Textboxes and Global var  ------------------------------->
<!----------------------------------------------------------------------------------------------------->	
<script>
	// clear the single target word textboxes
	function ClearSingleTargetTextboxes()
	{
		var pQueryTextbox = document.getElementById('SingleTargetWord1Textbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord2Textbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord3Textbox');
		pQueryTextbox.value = "";
		pQueryTextbox = document.getElementById('SingleTargetWord4Textbox');
		pQueryTextbox.value = "";	
	}

	// clear all the user input textboxes
	function ClearAllUserInputTextBoxes()
	{
		ClearTextBox('TargetWordTextbox');
		ClearTextBox('LexiconItemTextbox');
		ClearTextBox('ExpansionTextbox');
		ClearTextBox('FunctionTextbox');
		ClearTextBox('RootTextbox');
		ClearTextBox('SubcoordinatingTextbox');
		ClearTextBox('MoodTextbox');
		ClearTextBox('ValueTextbox');
		ClearTextBox('IdTextbox');
		ClearTextBox('PosTextbox');
		ClearTextBox('ConsecutiveTextbox');
		ClearTextBox('MultiWordTextbox');
		ClearTextBox('MweTextbox');
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
		ClearUserMenu();
		WriteQuery();
	}

	// clear current target-word, max/min word between current target-word, query compute GUI
	function ClearTargetWord(Index)
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

	function ClearUserMenu()
	{
		ResetDropListsMenu();
		ClearAllUserInputTextBoxes();
	}
</script>


<!----------------------------------------------------------------------------------------------------->
<!---------------------------------------- Update global variables ------------------------------------>
<!----------------------------------------------------------------------------------------------------->
<script>
	// change the current word index to input value, called by the switch word buttons
	// only current word changing when translating the query GUI. 
	function ChangeCurrentWord(iCurrentWord)
	{
		g_iCurrentTargetWordIndex = parseInt(iCurrentWord,10); // parsing to int, '10' - decimal base
		ChangeCurrentWordButtonsEffect(iCurrentWord);
	}

	// make the current word button appear pressed and paint in red
	function ChangeCurrentWordButtonsEffect(iCurrentButton)
	{
		// paint all buttons in black
		document.getElementById('ChangeCurrentWordButton1').style.color = 'black';
		document.getElementById('ChangeCurrentWordButton2').style.color = 'black';
		document.getElementById('ChangeCurrentWordButton3').style.color = 'black';
		document.getElementById('ChangeCurrentWordButton4').style.color = 'black';

		// make all buttons appear unpressed 
		document.getElementById('ChangeCurrentWordButton1').style.borderStyle = '';
		document.getElementById('ChangeCurrentWordButton2').style.borderStyle = '';
		document.getElementById('ChangeCurrentWordButton3').style.borderStyle = '';
		document.getElementById('ChangeCurrentWordButton4').style.borderStyle = '';  

		// make the current word button appear pressed and paint in red
		switch(iCurrentButton)
		{
		case 0:
			document.getElementById('ChangeCurrentWordButton1').style.color = 'red';
			document.getElementById('ChangeCurrentWordButton1').style.borderStyle = 'inset';
			break;
		case 1:
			document.getElementById('ChangeCurrentWordButton2').style.color = 'red';
			document.getElementById('ChangeCurrentWordButton2').style.borderStyle = 'inset';
			break;
		case 2:
			document.getElementById('ChangeCurrentWordButton3').style.color = 'red';
			document.getElementById('ChangeCurrentWordButton3').style.borderStyle = 'inset';
			break;
		case 3:
			document.getElementById('ChangeCurrentWordButton4').style.color = 'red';
			document.getElementById('ChangeCurrentWordButton4').style.borderStyle = 'inset';
			break;
		default:
			document.getElementById('ChangeCurrentWordButton1').style.color = 'red';
			document.getElementById('ChangeCurrentWordButton1').style.borderStyle = 'inset';
			break;
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

	// appanding the operator Not '!' to current word
	// writing the query again at the end, so the user can see the effect immediately 
	function AppandOperatorNot()
	{ 
		if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] += " !";
		else
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] = " !";
		WriteQuery();
	}

	// appanding no prefixes to current word (all prefixes = 'NNN')  
	// writing the query again at the end, so the user can see the effect immediately 
	function AppandNoPrefixes()
	{ 
		if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] += " & (prefix1=\"NNN\" & prefix2=\"NNN\" & prefix3=\"NNN\" & prefix4=\"NNN\" & prefix5=\"NNN\" & prefix6=\"NNN\")";
		else
			g_aTargetWordsArr[g_iCurrentTargetWordIndex] = "(prefix1=\"NNN\" & prefix2=\"NNN\" & prefix3=\"NNN\" & prefix4=\"NNN\" & prefix5=\"NNN\" & prefix6=\"NNN\")";
		WriteQuery();
	}
	
	// this function gets all the data from the DropLists in CQP syntax and inserts it to the global variable
	function TranslateComputeQueryGUI()
	{
		var FullQuery = null;

		// get value of target word textbox in CQP syntax
		var TempQuery = GetTargetWord();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of LexiconItem Textbox
		var TempQuery = GetLexiconItem();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of prefix1 DropLists
		var TempQuery = GetPrefix1();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of prefix2 DropLists
		var TempQuery = GetPrefix2();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of prefix3 DropLists
		var TempQuery = GetPrefix3();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of prefix4 DropLists
		var TempQuery = GetPrefix4();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of prefix5 DropLists
		var TempQuery = GetPrefix5();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of prefix6 DropLists
		var TempQuery = GetPrefix6();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of base DropLists
		var TempQuery = Getbase();
		if(TempQuery)
		{
			if(FullQuery) { FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of sufix DropLists
		var TempQuery = Getsuffix();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}
	
		// get the CQP syntax of Expansion Textbox
		var TempQuery = GetExpansion();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Function Textbox
		var TempQuery = GetFunction();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Root Textbox
		var TempQuery = getRoot();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Subcoordinating Textbox
		var TempQuery = GetSubcoordinating();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Mood Textbox
		var TempQuery = GetMood();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Value Textbox
		var TempQuery = GetValue();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}
		 
		// get the CQP syntax of Id Textbox
		var TempQuery = GetId();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Pos Textbox
		var TempQuery = GetPos();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of Consecutive Textbox
		var TempQuery = GetConsecutive();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}
		  
		// get the CQP syntax of MultiWord Textbox
		var TempQuery = GetMultiWord();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// get the CQP syntax of MWE Textbox
		var TempQuery = GetMWE();
		if(TempQuery)
		{
			if(FullQuery) {	FullQuery += " & " + TempQuery; }
			else { FullQuery = "(" + TempQuery; }
		}

		// update the global target word with the new added query if needed
		if(FullQuery)
		{
			FullQuery += ")";
			if(g_aTargetWordsArr[g_iCurrentTargetWordIndex])
				g_aTargetWordsArr[g_iCurrentTargetWordIndex] += FullQuery;
			else
				g_aTargetWordsArr[g_iCurrentTargetWordIndex] = FullQuery;
		}
	} 	
</script>

<!----------------------------------------------------------------------------------------------------->
<!-------------------------------------- TextBoxes Translating ---------------------------------------->
<!----------------------------------------------------------------------------------------------------->
<script>
	//read the target word from texbox and return it in CQP syntax
	function GetTargetWord()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('TargetWordTextbox');
		if(TempTextBox.value)
			ReturnValue = "word=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read LexiconItem from texbox and return it in CQP syntax
	function GetLexiconItem()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('LexiconItemTextbox');
		if(TempTextBox.value)
			ReturnValue = "lexiconitem=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Expansion from texbox and return it in CQP syntax
	function GetExpansion()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('ExpansionTextbox');
		if(TempTextBox.value)
			ReturnValue = "expansion=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Function from texbox and return it in CQP syntax
	function GetFunction()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('FunctionTextbox');
		if(TempTextBox.value)
			ReturnValue = "function=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Root from texbox and return it in CQP syntax
	function getRoot()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('RootTextbox');
		if(TempTextBox.value)
			ReturnValue = "root=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Subcoordinating from texbox and return it in CQP syntax
	function GetSubcoordinating()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('SubcoordinatingTextbox');
		if(TempTextBox.value)
			ReturnValue = "subcoordinating=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Mood from texbox and return it in CQP syntax
	function GetMood()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('MoodTextbox');
		if(TempTextBox.value)
			ReturnValue = "mood=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Value from texbox and return it in CQP syntax
	function GetValue()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('ValueTextbox');
		if(TempTextBox.value)
			ReturnValue = "value=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}
	
	//read Id from texbox and return it in CQP syntax
	function GetId()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('IdTextbox');
		if(TempTextBox.value)
			ReturnValue = "id=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Pos from texbox and return it in CQP syntax
	function GetPos()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('PosTextbox');
		if(TempTextBox.value)
			ReturnValue = "pos=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read Consecutive from texbox and return it in CQP syntax
	function GetConsecutive()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('ConsecutiveTextbox');
		if(TempTextBox.value)
			ReturnValue = "consecutive=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}
	
	//read MultiWord from texbox and return it in CQP syntax
	function GetMultiWord()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('MultiWordTextbox');
		if(TempTextBox.value)
			ReturnValue = "multiword=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}

	//read MWE from texbox and return it in CQP syntax
	function GetMWE()
	{
		var ReturnValue = null;
	
		var TempTextBox = document.getElementById('MweTextbox');
		if(TempTextBox.value)
			ReturnValue = "type=\"" + TempTextBox.value + "\"";
	
		return ReturnValue;	
	}
</script>



<!----------------------------------------------------------------------------------------------------->
<!------------------------------------ Drop Down Lists Translating ------------------------------------>
<!----------------------------------------------------------------------------------------------------->
<script>
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

		TempDropList = document.getElementById('BaseType');
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

	// read sufix from DropList and return it in CQP syntax
	function Getsuffix()
	{
		var bOneFlagIsOn = false; 	// if all flags are off, return null 
		var ReturnValue = "suffix=\"";

		var TempDropList = document.getElementById('sufixSurface');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('sufixFunction');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('sufixPerson');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char

		var TempDropList = document.getElementById('sufixGender');
		if(TempDropList.value != 'N')	// 'N' is the value of the empty option in the drop down list
		{
			ReturnValue += TempDropList.value;
			bOneFlagIsOn = true;
		}
		else
			ReturnValue += "."; 	// '.' in cqp syntax represent gloabl char 

		var TempDropList = document.getElementById('sufixNumber');
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
</script>

<!----------------------------------------------------------------------------------------------------->
<!------------------------------------ Drop Down Lists manipulating ----------------------------------->
<!----------------------------------------------------------------------------------------------------->
<script>
	// change BaseType DropList options according to the user choice in BaseBaseType DropList 
	function SetOptionsOfBaseTypeDropList(ValueOfBaseBaseTypeDropList)
	{
		ClearAllDropListOptions('BaseType');
		switch(ValueOfBaseBaseTypeDropList)
		{
		case 'd':  // case BaseBaseType is conjunction
			AddDropListOption('BaseType','a','coordinating');
			AddDropListOption('BaseType','b','subordinating');
			AddDropListOption('BaseType','c','relativizing');
			break;
		case 'f':	// case BaseBaseType is interrogative
			AddDropListOption('BaseType','a','pronoun');
			AddDropListOption('BaseType','b','proadverb');
			AddDropListOption('BaseType','c','prodet');
			AddDropListOption('BaseType','d','yesno');
			break;
		case 'l':	// case BaseBaseType is properName
			AddDropListOption('BaseType','a','interrogative');
			AddDropListOption('BaseType','b','personal');
			AddDropListOption('BaseType','c','demonstrative');
			AddDropListOption('BaseType','d','impersonal');
			AddDropListOption('BaseType','e','relativizer');
			AddDropListOption('BaseType','f','reflexive');
			break;
		case 'm':	// case BaseBaseType is punctuation
			AddDropListOption('BaseType','a','person');
			AddDropListOption('BaseType','b','location');
			AddDropListOption('BaseType','c','organization');
			AddDropListOption('BaseType','d','product');
			AddDropListOption('BaseType','e','dateTime');
			AddDropListOption('BaseType','f','country');
			AddDropListOption('BaseType','g','town');
			AddDropListOption('BaseType','h','language');
			AddDropListOption('BaseType','i','symbol');
			AddDropListOption('BaseType','j','art');
			AddDropListOption('BaseType','k','other');
			break;
		case 'n':	// case BaseBaseType is 
			AddDropListOption('BaseType','a','letter');
			AddDropListOption('BaseType','b','dash');
			AddDropListOption('BaseType','c','diacritic');
			AddDropListOption('BaseType','d','apostrophe');
			AddDropListOption('BaseType','e','whitespace');
			AddDropListOption('BaseType','f','bullet');
			AddDropListOption('BaseType','g','connector');
			AddDropListOption('BaseType','h','open');
			AddDropListOption('BaseType','i','close');
			AddDropListOption('BaseType','j','symbol');
			AddDropListOption('BaseType','k','mathSymbol');
			AddDropListOption('BaseType','l','currencySymbol');
			AddDropListOption('BaseType','m','Separator');
			AddDropListOption('BaseType','n','lineSeparator');
			break;
		case 'o':	// case BaseBaseType is numberExpression
			AddDropListOption('BaseType','a','date');
			AddDropListOption('BaseType','b','time');
			AddDropListOption('BaseType','c','gameScore');
			break;
		case 'p':	// case BaseBaseType is quantifier
			AddDropListOption('BaseType','a','amount');
			AddDropListOption('BaseType','b','partitive');
			AddDropListOption('BaseType','c','determiner');
			break;
		case 'r':	// case BaseBaseType is participle
			AddDropListOption('BaseType','a','noun');
			AddDropListOption('BaseType','b','adjective');
			AddDropListOption('BaseType','c','verb');
			break;
		case 's':	// case BaseBaseType is numeral
			AddDropListOption('BaseType','a','numeral ordinal');
			AddDropListOption('BaseType','b','numeral cardinal');
			AddDropListOption('BaseType','c','numeral fractional');
			AddDropListOption('BaseType','d','literal number');
			AddDropListOption('BaseType','e','gematria');
			break;
		default:
				break;
		}		
	}
 
	// reset al the drop down list menus 
	// 'N' is the value of the empty option in the DropList menu
	function ResetDropListsMenu()
	{
		// reset the prefix1 DropLists
		ChooseDropListEmptyOption('prefix1surface');
		ChooseDropListEmptyOption('prefix1function');
		ChooseDropListEmptyOption('prefix1multiword');
		
		// reset the prefix2 DropLists
		ChooseDropListEmptyOption('prefix2surface');
		ChooseDropListEmptyOption('prefix2function');
		ChooseDropListEmptyOption('prefix2multiword');
		
		// reset the prefix3 DropLists
		ChooseDropListEmptyOption('prefix3surface');
		ChooseDropListEmptyOption('prefix3function');
		ChooseDropListEmptyOption('prefix3multiword');

		// reset the prefix4 DropLists
		ChooseDropListEmptyOption('prefix4surface');
		ChooseDropListEmptyOption('prefix4function');
		ChooseDropListEmptyOption('prefix4multiword');

		// reset the prefix5 DropLists 
		ChooseDropListEmptyOption('prefix5surface');
		ChooseDropListEmptyOption('prefix5function');
		ChooseDropListEmptyOption('prefix5multiword');

		// reset the prefix6 DropLists
		ChooseDropListEmptyOption('prefix6surface');
		ChooseDropListEmptyOption('prefix6function');
		ChooseDropListEmptyOption('prefix6multiword');

		// reset the Base DropLists
		ChooseDropListEmptyOption('BaseBaseType');
		ChooseDropListEmptyOption('BaseGender');
		ChooseDropListEmptyOption('BaseNumber');
		ChooseDropListEmptyOption('BaseStatus');
		ChooseDropListEmptyOption('BaseDefiniteness');
		ChooseDropListEmptyOption('BaseForeign');
		ChooseDropListEmptyOption('BaseRegister');
		ChooseDropListEmptyOption('BaseSpelling');
		ChooseDropListEmptyOption('BasePerson');
		ChooseDropListEmptyOption('BaseTense');
		ChooseDropListEmptyOption('BaseBinyan');
		ChooseDropListEmptyOption('BasePolarity');
		ChooseDropListEmptyOption('BaseMultiWordPrefix');
		ChooseDropListEmptyOption('BaseType');

		// reset the sufix DropLists
		ChooseDropListEmptyOption('sufixSurface');
		ChooseDropListEmptyOption('sufixFunction');
		ChooseDropListEmptyOption('sufixPerson');
		ChooseDropListEmptyOption('sufixGender');
		ChooseDropListEmptyOption('sufixNumber');
	} 
</script>
