<script>
	var NumSupportSearchWord = 4;

	// indicate the word that the user is editing
	var g_iCurrentWordIndex = 0;

	// global arr size 4: cqp supports up to 4 words search
	var g_aWordSearchArr = new Array(NumSupportSearchWord);    

	// min number of words between search results
	var g_aMinWordsBetweenResults = new Array(NumSupportSearchWord-1); 

	// man number of words between search results 
	var g_aMaxWordsBetweenResults = new Array(NumSupportSearchWord-1); 
	
	function ComputeQuery()
	{
		if( !(g_aMaxWordsBetweenResults && g_aMaxWordsBetweenResults && g_aWordSearchArr) )
			alert("Sorry Somthing Is wrong with ComputeQuery()");
		else
		{
			var myTextField = document.getElementById('QueryWordTextBox');
			var myTextField2 = document.getElementById('QueryTextbox');
			myTextField2.value += " !The Start! ";


			g_aWordSearchArr[0] = "word=\"לפי\"";
			g_aWordSearchArr[1] = "word=\"מקורות\"";
			//g_aWordSearchArr[2] = "word=\"זרים\"";

			
			g_aMinWordsBetweenResults[1]=3;
			//g_aMaxWordsBetweenResults[1]=3;

			//g_aMinWordsBetweenResults[2]=3;
				

			WriteQuery();

			alert("clearing all");
			ClearCurrnet();
			WriteQuery();
	
			myTextField2.value += " !The End! " + myTextField.value;
		}
	}

	function WriteQuery()
	{
		ClearQueryTextbox();
		var pQueryTextbox = document.getElementById('QueryTextbox');

		// for each word
		for(var ii=0;ii<NumSupportSearchWord;ii++)
		{		
			if(g_aWordSearchArr[ii])
				pQueryTextbox.value += ("[" + g_aWordSearchArr[ii] + "] ");

			// print the min&max word between results if needed
			// for X words there is X-1 spaces between them
			if(ii <NumSupportSearchWord-1)
			{
				if(g_aMinWordsBetweenResults[ii] || g_aMaxWordsBetweenResults[ii])
				{
					pQueryTextbox.value += "[]{";
					if(g_aMinWordsBetweenResults[ii])
						pQueryTextbox.value += g_aMinWordsBetweenResults[ii];
					else
						pQueryTextbox.value += 0; // max but no min => min=0
					pQueryTextbox.value += ",";
					if(g_aMaxWordsBetweenResults[ii])
						pQueryTextbox.value += g_aMaxWordsBetweenResults[ii];
					pQueryTextbox.value += "} ";	
				}
			}
		}		
	}

	function ClearQueryTextbox()
	{
		var pQueryTextbox = document.getElementById('QueryTextbox');
		pQueryTextbox.value = "";	
	}

	function ClearAll()
	{
		for(var ii=0;ii<NumSupportSearchWord;ii++)
		{
			g_aMinWordsBetweenResults[ii] = null;
			g_aMaxWordsBetweenResults[ii] = null;
			g_aWordSearchArr[ii] = null;
		}
	}

	function ClearCurrnet()
	{
		g_aWordSearchArr[g_iCurrentWordIndex] = null;

		// clear the []{} before the currnet word  //  []{} is the max/min word between
		if(g_iCurrentWordIndex-1 >=0)
		{
			g_aMinWordsBetweenResults[g_iCurrentWordIndex-1] = null;
			g_aMaxWordsBetweenResults[g_iCurrentWordIndex-1] = null;
		}

		// clear the []{} after the currnet word  // []{} is the max/min word between
		if(g_iCurrentWordIndex < NumSupportSearchWord-1)
		{
			g_aMinWordsBetweenResults[g_iCurrentWordIndex] = null;
			g_aMaxWordsBetweenResults[g_iCurrentWordIndex] = null;
		}	
	} 

	function AppendOpenBracket() { g_aWordSearchArr[g_iCurrentWordIndex] += "("; }
</script>
