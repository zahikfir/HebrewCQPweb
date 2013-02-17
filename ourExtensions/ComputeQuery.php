<?php	echo " !!! in Construction  !!!"; ?>
<form id="queryComputeForm" onsubmit="return MyFunc()" method="post">
	<p>
	<label><b><u>First prefix</b></u></label>
		<br/><label><b>surface: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix1surface_N" name="prefix1surface" value="N"checked/>
			<lable>'מ'</label>
				<input type="radio" id="prefix1surface_a" name="prefix1surface" value="a"/>
			<lable>'ש'</label>
				<input type="radio" id="prefix1surface_b" name="prefix1surface" value="b"/>
			<lable>'ה'</label>
				<input type="radio" id="prefix1surface_c" name="prefix1surface" value="c"/>
			<lable>'ו'</label>
				<input type="radio" id="prefix1surface_d" name="prefix1surface" value="d"/>
			<lable>'כ'</label>
				<input type="radio" id="prefix1surface_e" name="prefix1surface" value="e"/>
			<lable>'ל'</label>
				<input type="radio" id="prefix1surface_f" name="prefix1surface" value="f"/>
			<lable>'ב'</label>
				<input type="radio" id="prefix1surface_g" name="prefix1surface" value="g"/>
			<lable>'כש'</label>
				<input type="radio" id="prefix1surface_h" name="prefix1surface" value="h"/>
			<lable>'מש'</label>
				<input type="radio" id="prefix1surface_i" name="prefix1surface" value="i"/>
			<lable>'מב'</label>
				<input type="radio" id="prefix1surface_j" name="prefix1surface" value="j"/>
			<lable>'מל'</label>
				<input type="radio" id="prefix1surface_k" name="prefix1surface" value="k"/>
			<lable>'בש'</label>
				<input type="radio" id="prefix1surface_l" name="prefix1surface" value="l"/>
			<lable>'לכש'</label>
				<input type="radio" id="prefix1surface_m" name="prefix1surface" value="m"/>
		<br/><label><b>function: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix1function_N" name="prefix1function" value="N"checked/>
			<lable>relativizer</label>
				<input type="radio" id="prefix1function_a" name="prefix1function" value="a"/>  
			<lable>conjunction</label>
				<input type="radio" id="prefix1function_b" name="prefix1function" value="b"/>  
			<lable>definite article</label>
				<input type="radio" id="prefix1function_c" name="prefix1function" value="c"/>  
			<lable>subordinatingConjunction</label>
				<input type="radio" id="prefix1function_d" name="prefix1function" value="d"/>  
			<lable>relativizer/subConj</label>
				<input type="radio" id="prefix1function_e" name="prefix1function" value="e"/>  
			<lable>temporalSubConj</label>
				<input type="radio" id="prefix1function_f" name="prefix1function" value="f"/>  
			<lable>interrogative</label>
				<input type="radio" id="prefix1function_g" name="prefix1function" value="g"/>  
			<lable>tenseInversion</label>
				<input type="radio" id="prefix1function_h" name="prefix1function" value="h"/>  
			<lable>preposition</label>
				<input type="radio" id="prefix1function_i" name="prefix1function" value="i"/>  
			<lable>adverb</label>
				<input type="radio" id="prefix1function_j" name="prefix1function" value="j"/>
		<br/><label><b>multiword: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix1multiword_N" name="prefix1multiword" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="prefix1multiword_a" name="prefix1multiword_a" value="a"/>  
			<lable>0</label>
				<input type="radio" id="prefix1multiword_b" name="prefix1multiword_b" value="b"/>  
		
	<br/><br/><label><b><u>Second prefix</b></u></label>
		<br/><label><b>surface: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix2surface_N" name="prefix2surface" value="N"checked/>
			<lable>'מ'</label>
				<input type="radio" id="prefix2surface_a" name="prefix2surface" value="a"/>
			<lable>'ש'</label>
				<input type="radio" id="prefix2surface_b" name="prefix2surface" value="b"/>
			<lable>'ה'</label>
				<input type="radio" id="prefix2surface_c" name="prefix2surface" value="c"/>
			<lable>'ו'</label>
				<input type="radio" id="prefix2surface_d" name="prefix2surface" value="d"/>
			<lable>'כ'</label>
				<input type="radio" id="prefix2surface_e" name="prefix2surface" value="e"/>
			<lable>'ל'</label>
				<input type="radio" id="prefix2surface_f" name="prefix2surface" value="f"/>
			<lable>'ב'</label>
				<input type="radio" id="prefix2surface_g" name="prefix2surface" value="g"/>
			<lable>'כש'</label>
				<input type="radio" id="prefix2surface_h" name="prefix2surface" value="h"/>
			<lable>'מש'</label>
				<input type="radio" id="prefix2surface_i" name="prefix2surface" value="i"/>
			<lable>'מב'</label>
				<input type="radio" id="prefix2surface_j" name="prefix2surface" value="j"/>
			<lable>'מל'</label>
				<input type="radio" id="prefix2surface_k" name="prefix2surface" value="k"/>
			<lable>'בש'</label>
				<input type="radio" id="prefix2surface_l" name="prefix2surface" value="l"/>
			<lable>'לכש'</label>
				<input type="radio" id="prefix2surface_m" name="prefix2surface" value="m"/>
		<br/><label><b>function: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix2function_N" name="prefix2function" value="N"checked/>
			<lable>relativizer</label>
				<input type="radio" id="prefix2function_a" name="prefix2function" value="a"/>  
			<lable>conjunction</label>
				<input type="radio" id="prefix2function_b" name="prefix2function" value="b"/>  
			<lable>definite article</label>
				<input type="radio" id="prefix2function_c" name="prefix2function" value="c"/>  
			<lable>subordinatingConjunction</label>
				<input type="radio" id="prefix2function_d" name="prefix2function" value="d"/>  
			<lable>relativizer/subConj</label>
				<input type="radio" id="prefix2function_e" name="prefix2function" value="e"/>  
			<lable>temporalSubConj</label>
				<input type="radio" id="prefix2function_f" name="prefix2function" value="f"/>  
			<lable>interrogative</label>
				<input type="radio" id="prefix2function_g" name="prefix2function" value="g"/>  
			<lable>tenseInversion</label>
				<input type="radio" id="prefix2function_h" name="prefix2function" value="h"/>  
			<lable>preposition</label>
				<input type="radio" id="prefix2function_i" name="prefix2function" value="i"/>  
			<lable>adverb</label>
				<input type="radio" id="prefix2function_j" name="prefix2function" value="j"/>
		<br/><label><b>multiword: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix2multiword_N" name="prefix2multiword" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="prefix2multiword_a" name="prefix2multiword_a" value="a"/>  
			<lable>0</label>
				<input type="radio" id="prefix2multiword_b" name="prefix2multiword_b" value="b"/>  

	<br/><br/><label><b><u>Third prefix</b></u></label>
		<br/><label><b>surface: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix3surface_N" name="prefix3surface" value="N"checked/>
			<lable>'מ'</label>
				<input type="radio" id="prefix3surface_a" name="prefix3surface" value="a"/>
			<lable>'ש'</label>
				<input type="radio" id="prefix3surface_b" name="prefix3surface" value="b"/>
			<lable>'ה'</label>
				<input type="radio" id="prefix3surface_c" name="prefix3surface" value="c"/>
			<lable>'ו'</label>
				<input type="radio" id="prefix3surface_d" name="prefix3surface" value="d"/>
			<lable>'כ'</label>
				<input type="radio" id="prefix3surface_e" name="prefix3surface" value="e"/>
			<lable>'ל'</label>
				<input type="radio" id="prefix3surface_f" name="prefix3surface" value="f"/>
			<lable>'ב'</label>
				<input type="radio" id="prefix3surface_g" name="prefix3surface" value="g"/>
			<lable>'כש'</label>
				<input type="radio" id="prefix3surface_h" name="prefix3surface" value="h"/>
			<lable>'מש'</label>
				<input type="radio" id="prefix3surface_i" name="prefix3surface" value="i"/>
			<lable>'מב'</label>
				<input type="radio" id="prefix3surface_j" name="prefix3surface" value="j"/>
			<lable>'מל'</label>
				<input type="radio" id="prefix3surface_k" name="prefix3surface" value="k"/>
			<lable>'בש'</label>
				<input type="radio" id="prefix3surface_l" name="prefix3surface" value="l"/>
			<lable>'לכש'</label>
				<input type="radio" id="prefix3surface_m" name="prefix3surface" value="m"/>
		<br/><label><b>function: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix3function_N" name="prefix3function" value="N"checked/>
			<lable>relativizer</label>
				<input type="radio" id="prefix3function_a" name="prefix3function" value="a"/>  
			<lable>conjunction</label>
				<input type="radio" id="prefix3function_b" name="prefix3function" value="b"/>  
			<lable>definite article</label>
				<input type="radio" id="prefix3function_c" name="prefix3function" value="c"/>  
			<lable>subordinatingConjunction</label>
				<input type="radio" id="prefix3function_d" name="prefix3function" value="d"/>  
			<lable>relativizer/subConj</label>
				<input type="radio" id="prefix3function_e" name="prefix3function" value="e"/>  
			<lable>temporalSubConj</label>
				<input type="radio" id="prefix3function_f" name="prefix3function" value="f"/>  
			<lable>interrogative</label>
				<input type="radio" id="prefix3function_g" name="prefix3function" value="g"/>  
			<lable>tenseInversion</label>
				<input type="radio" id="prefix3function_h" name="prefix3function" value="h"/>  
			<lable>preposition</label>
				<input type="radio" id="prefix3function_i" name="prefix3function" value="i"/>  
			<lable>adverb</label>
				<input type="radio" id="prefix3function_j" name="prefix3function" value="j"/>
		<br/><label><b>multiword: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix3multiword_N" name="prefix3multiword" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="prefix3multiword_a" name="prefix3multiword_a" value="a"/>  
			<lable>0</label>
				<input type="radio" id="prefix3multiword_b" name="prefix3multiword_b" value="b"/> 

	<br/><br/><label><b><u>Fourth prefix</b></u></label>
		<br/><label><b>surface: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix4surface_N" name="prefix4surface" value="N"checked/>
			<lable>'מ'</label>
				<input type="radio" id="prefix4surface_a" name="prefix4surface" value="a"/>
			<lable>'ש'</label>
				<input type="radio" id="prefix4surface_b" name="prefix4surface" value="b"/>
			<lable>'ה'</label>
				<input type="radio" id="prefix4surface_c" name="prefix4surface" value="c"/>
			<lable>'ו'</label>
				<input type="radio" id="prefix4surface_d" name="prefix4surface" value="d"/>
			<lable>'כ'</label>
				<input type="radio" id="prefix4surface_e" name="prefix4surface" value="e"/>
			<lable>'ל'</label>
				<input type="radio" id="prefix4surface_f" name="prefix4surface" value="f"/>
			<lable>'ב'</label>
				<input type="radio" id="prefix4surface_g" name="prefix4surface" value="g"/>
			<lable>'כש'</label>
				<input type="radio" id="prefix4surface_h" name="prefix4surface" value="h"/>
			<lable>'מש'</label>
				<input type="radio" id="prefix4surface_i" name="prefix4surface" value="i"/>
			<lable>'מב'</label>
				<input type="radio" id="prefix4surface_j" name="prefix4surface" value="j"/>
			<lable>'מל'</label>
				<input type="radio" id="prefix4surface_k" name="prefix4surface" value="k"/>
			<lable>'בש'</label>
				<input type="radio" id="prefix4surface_l" name="prefix4surface" value="l"/>
			<lable>'לכש'</label>
				<input type="radio" id="prefix4surface_m" name="prefix4surface" value="m"/>
		<br/><label><b>function: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix4function_N" name="prefix4function" value="N"checked/>
			<lable>relativizer</label>
				<input type="radio" id="prefix4function_a" name="prefix4function" value="a"/>  
			<lable>conjunction</label>
				<input type="radio" id="prefix4function_b" name="prefix4function" value="b"/>  
			<lable>definite article</label>
				<input type="radio" id="prefix4function_c" name="prefix4function" value="c"/>  
			<lable>subordinatingConjunction</label>
				<input type="radio" id="prefix4function_d" name="prefix4function" value="d"/>  
			<lable>relativizer/subConj</label>
				<input type="radio" id="prefix4function_e" name="prefix4function" value="e"/>  
			<lable>temporalSubConj</label>
				<input type="radio" id="prefix4function_f" name="prefix4function" value="f"/>  
			<lable>interrogative</label>
				<input type="radio" id="prefix4function_g" name="prefix4function" value="g"/>  
			<lable>tenseInversion</label>
				<input type="radio" id="prefix4function_h" name="prefix4function" value="h"/>  
			<lable>preposition</label>
				<input type="radio" id="prefix4function_i" name="prefix4function" value="i"/>  
			<lable>adverb</label>
				<input type="radio" id="prefix4function_j" name="prefix4function" value="j"/>
		<br/><label><b>multiword: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix4multiword_N" name="prefix4multiword" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="prefix4multiword_a" name="prefix4multiword_a" value="a"/>  
			<lable>0</label>
				<input type="radio" id="prefix4multiword_b" name="prefix4multiword_b" value="b"/>

	<br/><br/><label><b><u>Fifth prefix</b></u></label>
		<br/><label><b>surface: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix5surface_N" name="prefix5surface" value="N"checked/>
			<lable>'מ'</label>
				<input type="radio" id="prefix5surface_a" name="prefix5surface" value="a"/>
			<lable>'ש'</label>
				<input type="radio" id="prefix5surface_b" name="prefix5surface" value="b"/>
			<lable>'ה'</label>
				<input type="radio" id="prefix5surface_c" name="prefix5surface" value="c"/>
			<lable>'ו'</label>
				<input type="radio" id="prefix5surface_d" name="prefix5surface" value="d"/>
			<lable>'כ'</label>
				<input type="radio" id="prefix5surface_e" name="prefix5surface" value="e"/>
			<lable>'ל'</label>
				<input type="radio" id="prefix5surface_f" name="prefix5surface" value="f"/>
			<lable>'ב'</label>
				<input type="radio" id="prefix5surface_g" name="prefix5surface" value="g"/>
			<lable>'כש'</label>
				<input type="radio" id="prefix5surface_h" name="prefix5surface" value="h"/>
			<lable>'מש'</label>
				<input type="radio" id="prefix5surface_i" name="prefix5surface" value="i"/>
			<lable>'מב'</label>
				<input type="radio" id="prefix5surface_j" name="prefix5surface" value="j"/>
			<lable>'מל'</label>
				<input type="radio" id="prefix5surface_k" name="prefix5surface" value="k"/>
			<lable>'בש'</label>
				<input type="radio" id="prefix5surface_l" name="prefix5surface" value="l"/>
			<lable>'לכש'</label>
				<input type="radio" id="prefix5surface_m" name="prefix5surface" value="m"/>
		<br/><label><b>function: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix5function_N" name="prefix5function" value="N"checked/>
			<lable>relativizer</label>
				<input type="radio" id="prefix5function_a" name="prefix5function" value="a"/>  
			<lable>conjunction</label>
					<input type="radio" id="prefix5function_b" name="prefix5function" value="b"/>  
			<lable>definite article</label>
				<input type="radio" id="prefix5function_c" name="prefix5function" value="c"/>  
			<lable>subordinatingConjunction</label>
				<input type="radio" id="prefix5function_d" name="prefix5function" value="d"/>  
			<lable>relativizer/subConj</label>
				<input type="radio" id="prefix5function_e" name="prefix5function" value="e"/>  
			<lable>temporalSubConj</label>
				<input type="radio" id="prefix5function_f" name="prefix5function" value="f"/>  
			<lable>interrogative</label>
				<input type="radio" id="prefix5function_g" name="prefix5function" value="g"/>  
			<lable>tenseInversion</label>
				<input type="radio" id="prefix5function_h" name="prefix5function" value="h"/>  
			<lable>preposition</label>
				<input type="radio" id="prefix5function_i" name="prefix5function" value="i"/>  
			<lable>adverb</label>
				<input type="radio" id="prefix5function_j" name="prefix5function" value="j"/>
		<br/><label><b>multiword: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix5multiword_N" name="prefix5multiword" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="prefix5multiword_a" name="prefix5multiword_a" value="a"/>  
			<lable>0</label>
				<input type="radio" id="prefix5multiword_b" name="prefix5multiword_b" value="b"/> 

	<br/><br/><label><b><u>Sixth prefix</b></u></label>
		<br/><label><b>surface: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix6surface_N" name="prefix6surface" value="N"checked/>
			<lable>'מ'</label>
				<input type="radio" id="prefix6surface_a" name="prefix6surface" value="a"/>
			<lable>'ש'</label>
				<input type="radio" id="prefix6surface_b" name="prefix6surface" value="b"/>
			<lable>'ה'</label>
				<input type="radio" id="prefix6surface_c" name="prefix6surface" value="c"/>
			<lable>'ו'</label>
				<input type="radio" id="prefix6surface_d" name="prefix6surface" value="d"/>
			<lable>'כ'</label>
				<input type="radio" id="prefix6surface_e" name="prefix6surface" value="e"/>
			<lable>'ל'</label>
				<input type="radio" id="prefix6surface_f" name="prefix6surface" value="f"/>
			<lable>'ב'</label>
				<input type="radio" id="prefix6surface_g" name="prefix6surface" value="g"/>
			<lable>'כש'</label>
				<input type="radio" id="prefix6surface_h" name="prefix6surface" value="h"/>
			<lable>'מש'</label>
				<input type="radio" id="prefix6surface_i" name="prefix6surface" value="i"/>
			<lable>'מב'</label>
				<input type="radio" id="prefix6surface_j" name="prefix6surface" value="j"/>
			<lable>'מל'</label>
				<input type="radio" id="prefix6surface_k" name="prefix6surface" value="k"/>
			<lable>'בש'</label>
				<input type="radio" id="prefix6surface_l" name="prefix6surface" value="l"/>
			<lable>'לכש'</label>
				<input type="radio" id="prefix6surface_m" name="prefix6surface" value="m"/>
		<br/><label><b>function: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix6function_N" name="prefix6function" value="N"checked/>
			<lable>relativizer</label>
				<input type="radio" id="prefix6function_a" name="prefix6function" value="a"/>  
			<lable>conjunction</label>
				<input type="radio" id="prefix6function_b" name="prefix6function" value="b"/>  
			<lable>definite article</label>
				<input type="radio" id="prefix6function_c" name="prefix6function" value="c"/>  
			<lable>subordinatingConjunction</label>
				<input type="radio" id="prefix6function_d" name="prefix6function" value="d"/>  
			<lable>relativizer/subConj</label>
				<input type="radio" id="prefix6function_e" name="prefix6function" value="e"/>  
			<lable>temporalSubConj</label>
				<input type="radio" id="prefix6function_f" name="prefix6function" value="f"/>  
			<lable>interrogative</label>
				<input type="radio" id="prefix6function_g" name="prefix6function" value="g"/>  
			<lable>tenseInversion</label>
				<input type="radio" id="prefix6function_h" name="prefix6function" value="h"/>  
			<lable>preposition</label>
				<input type="radio" id="prefix6function_i" name="prefix6function" value="i"/>  
			<lable>adverb</label>
				<input type="radio" id="prefix6function_j" name="prefix6function" value="j"/>
		<br/><label><b>multiword: </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="prefix6multiword_N" name="prefix6multiword" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="prefix6multiword_a" name="prefix6multiword_a" value="a"/>  
			<lable>0</label>
				<input type="radio" id="prefix6multiword_b" name="prefix6multiword_b" value="b"/>

	<br/><br/><label><b><u>Base</b></u></label>
		<br/><label><b>base type: </b></label><br/>  
			<lable>unspecified</label>
				<input type="radio" id="BaseBaseType_N" name="BaseBaseType" value="N"checked/>
			<lable>adjective</label>
				<input type="radio" id="BaseBaseType_a" name="BaseBaseType" value="a"/>
			<lable>adverb</label>
				<input type="radio" id="BaseBaseType_b" name="BaseBaseType" value="b"/>
			<lable>zevel</label>
				<input type="radio" id="BaseBaseType_c" name="BaseBaseType" value="c"/>
			<lable>conjunction</label>
				<input type="radio" id="BaseBaseType_d" name="BaseBaseType" value="d"/>
			<lable>interjection</label>
				<input type="radio" id="BaseBaseType_e" name="BaseBaseType" value="e"/>
			<lable>interrogative</label>
				<input type="radio" id="BaseBaseType_f" name="BaseBaseType" value="f"/>
			<lable>negation</label>
				<input type="radio" id="BaseBaseType_g" name="BaseBaseType" value="g"/>
			<lable>foreign</label>
				<input type="radio" id="BaseBaseType_h" name="BaseBaseType" value="h"/>
			<lable>url</label>
				<input type="radio" id="BaseBaseType_i" name="BaseBaseType" value="i"/>
			<lable>noun</label>
				<input type="radio" id="BaseBaseType_j" name="BaseBaseType" value="j"/>
			<lable>preposition</label>
				<input type="radio" id="BaseBaseType_k" name="BaseBaseType" value="k"/>
			<lable>pronoun</label>
				<input type="radio" id="BaseBaseType_l" name="BaseBaseType" value="l"/>
			<lable>properName</label>
				<input type="radio" id="BaseBaseType_m" name="BaseBaseType" value="m"/>
			<lable>punctuation</label>
				<input type="radio" id="BaseBaseType_n" name="BaseBaseType" value="n"/>
			<lable>numberExpression</label>
				<input type="radio" id="BaseBaseType_o" name="BaseBaseType" value="o"/>
			<lable>quantifier</label>
				<input type="radio" id="BaseBaseType_p" name="BaseBaseType" value="p"/>
			<lable>verb</label>
				<input type="radio" id="BaseBaseType_q" name="BaseBaseType" value="q"/>
			<lable>participle</label>
				<input type="radio" id="BaseBaseType_r" name="BaseBaseType" value="r"/>
			<lable>numeral</label>
				<input type="radio" id="BaseBaseType_s" name="BaseBaseType" value="s"/>
			<lable>existential</label>
				<input type="radio" id="BaseBaseType_t" name="BaseBaseType" value="t"/>
			<lable>impersonal</label>
				<input type="radio" id="BaseBaseType_u" name="BaseBaseType" value="u"/>
			<lable>wPrefix</label>
				<input type="radio" id="BaseBaseType_v" name="BaseBaseType" value="v"/>
			<lable>modal</label>
				<input type="radio" id="BaseBaseType_w" name="BaseBaseType" value="w"/>
			<lable>copula</label>
				<input type="radio" id="BaseBaseType_x" name="BaseBaseType" value="x"/>
			<lable>title</label>
				<input type="radio" id="BaseBaseType_y" name="BaseBaseType" value="y"/>
			<lable>MWE</label>
				<input type="radio" id="BaseBaseType_z" name="BaseBaseType" value="z"/>
		<br/><label><b>gender: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseGender_N" name="BaseGender" value="N"checked/>
			<lable>masculine</label>
				<input type="radio" id="BaseGender_a" name="BaseGender" value="a"/>
			<lable>feminine</label>
				<input type="radio" id="BaseGender_b" name="BaseGender" value="b"/>
			<lable>masculine and feminine</label>
				<input type="radio" id="BaseGender_c" name="BaseGender" value="c"/>
		<br/><label><b>number: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseNumber_N" name="BaseNumber" value="N"checked/>
			<lable>singular</label>
				<input type="radio" id="BaseNumber_a" name="BaseNumber" value="a"/> 
			<lable>plural</label>
				<input type="radio" id="BaseNumber_b" name="BaseNumber" value="b"/> 
			<lable>dual</label>
				<input type="radio" id="BaseNumber_c" name="BaseNumber" value="c"/> 
			<lable>dual and plural</label>
				<input type="radio" id="BaseNumber_d" name="BaseNumber" value="d"/> 
			<lable>singular and plural</label>
				<input type="radio" id="BaseNumber_e" name="BaseNumber" value="e"/>
		<br/><label><b>status: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseStatus_N" name="BaseStatus" value="N"checked/>
			<lable>absolute</label>
				<input type="radio" id="BaseStatus_a" name="BaseStatus" value="a"/>
			<lable>construct</label>
				<input type="radio" id="BaseStatus_b" name="BaseStatus" value="b"/>
			<lable>absolute and construct</label>
				<input type="radio" id="BaseStatus_c" name="BaseStatus" value="c"/>	
		<br/><label><b>definiteness: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseDefiniteness_N" name="BaseDefiniteness" value="N"checked/>	
			<lable>1</label>
				<input type="radio" id="BaseDefiniteness_a" name="BaseDefiniteness" value="a"/> 
			<lable>0</label>
				<input type="radio" id="BaseDefiniteness_b" name="BaseDefiniteness" value="b"/> 
		<br/><label><b>foreign: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseForeign_N" name="BaseForeign" value="N"checked/>	
			<lable>1</label>
				<input type="radio" id="BaseForeign_a" name="BaseForeign" value="a"/> 
			<lable>0</label>
				<input type="radio" id="BaseForeign_b" name="BaseForeign" value="b"/>
		<br/><label><b>register: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseRegister_N" name="BaseRegister" value="N"checked/>	
			<lable>formal</label>
				<input type="radio" id="BaseRegister_a" name="BaseRegister" value="a"/> 
			<lable>archaic</label>
				<input type="radio" id="BaseRegister_b" name="BaseRegister" value="b"/>
			<lable>informal</label>
				<input type="radio" id="BaseRegister_c" name="BaseRegister" value="c"/>
		<br/><label><b>spelling: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BaseSpelling_N" name="BaseSpelling" value="N"checked/>	
			<lable>standard</label>
				<input type="radio" id="BaseSpelling_a" name="BaseSpelling" value="a"/> 
			<lable>irregular</label>
				<input type="radio" id="BaseSpelling_b" name="BaseSpelling" value="b"/>
		<br/><label><b>person: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="BasePerson_N" name="BasePerson" value="N"checked/>	
			<lable>first</label>
				<input type="radio" id="BasePerson_a" name="BasePerson" value="a"/> 
			<lable>second</label>
				<input type="radio" id="BasePerson_b" name="BasePerson" value="b"/>
			<lable>third</label>
				<input type="radio" id="BasePerson_c" name="BasePerson" value="c"/>
			<lable>any</label>
				<input type="radio" id="BasePerson_d" name="BasePerson" value="d"/>
		<br/><label><b>tense: </b></label><br/>  
			<lable>unspecified</label>
				<input type="radio" id="BaseTense_N" name="BaseTense" value="N"checked/>
			<lable>past</label>
				<input type="radio" id="BaseTense_a" name="BaseTense" value="a"/>
			<lable>present</label>
				<input type="radio" id="BaseTense_b" name="BaseTense" value="b"/>
			<lable>beinoni</label>
				<input type="radio" id="BaseTense_c" name="BaseTense" value="c"/>
			<lable>future</label>
				<input type="radio" id="BaseTense_d" name="BaseTense" value="d"/>
			<lable>imperative</label>
				<input type="radio" id="BaseTense_e" name="BaseTense" value="e"/>
			<lable>infinitive</label>
				<input type="radio" id="BaseTense_f" name="BaseTense" value="f"/>
			<lable>bareInfinitive</label>
				<input type="radio" id="BaseTense_g" name="BaseTense" value="g"/>
		<br/><label><b>binyan: </b></label><br/>  
			<lable>unspecified</label>
				<input type="radio" id="BaseBinyan_N" name="BaseBinyan" value="N"checked/>
			<lable>Pa'al</label>
				<input type="radio" id="BaseBinyan_a" name="BaseBinyan" value="a"/>
			<lable>Nif'al</label>
				<input type="radio" id="BaseBinyan_b" name="BaseBinyan" value="b"/>
			<lable>Pi'el</label>
				<input type="radio" id="BaseBinyan_c" name="BaseBinyan" value="c"/>
			<lable>Pu'al</label>
				<input type="radio" id="BaseBinyan_d" name="BaseBinyan" value="d"/>
			<lable>Hif'il</label>
				<input type="radio" id="BaseBinyan_e" name="BaseBinyan" value="e"/>
			<lable>Huf'al</label>
				<input type="radio" id="BaseBinyan_f" name="BaseBinyan" value="f"/>
			<lable>Hitpa'el</label>
				<input type="radio" id="BaseBinyan_g" name="BaseBinyan" value="g"/>
		<br/><label><b>polarity: </b></label><br/>  
			<lable>unspecified</label>
				<input type="radio" id="BasePolarity_N" name="BasePolarity" value="N"checked/>
			<lable>positive</label>
				<input type="radio" id="BasePolarity_a" name="BasePolarity" value="a"/>
			<lable>negative</label>
				<input type="radio" id="BasePolarity_b" name="BasePolarity" value="b"/>
		<br/><label><b>multiWord Prefix Exist: </b></label><br/>  
			<lable>unspecified</label>
				<input type="radio" id="BaseMultiWordPrefix_N" name="BaseMultiWordPrefix" value="N"checked/>
			<lable>1</label>
				<input type="radio" id="BaseMultiWordPrefix_a" name="BaseMultiWordPrefix" value="a"/>
			<lable>0</label>
				<input type="radio" id="BaseMultiWordPrefix_b" name="BaseMultiWordPrefix" value="b"/>

	<br/><br/><label><b><u>sufix</b></u></label>
		<br/><label><b>surface </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="sufixSurface_N" name="sufixSurface" value="N"checked/>
			<lable>'י'</label>
				<input type="radio" id="sufixSurface_a" name="sufixSurface" value="a"/>
			<lable>'ך'</label>
				<input type="radio" id="sufixSurface_b" name="sufixSurface" value="b"/>
			<lable>'ו'</label>
				<input type="radio" id="sufixSurface_c" name="sufixSurface" value="c"/>
			<lable>'ה'</label>
				<input type="radio" id="sufixSurface_d" name="sufixSurface" value="d"/>
			<lable>'נו'</label>
				<input type="radio" id="sufixSurface_e" name="sufixSurface" value="e"/>
			<lable>'כם'</label>
				<input type="radio" id="sufixSurface_f" name="sufixSurface" value="f"/>
			<lable>'כן'</label>
				<input type="radio" id="sufixSurface_g" name="sufixSurface" value="g"/>
			<lable>'ם'</label>
				<input type="radio" id="sufixSurface_h" name="sufixSurface" value="h"/>
			<lable>'ן'</label>
				<input type="radio" id="sufixSurface_i" name="sufixSurface" value="i"/>
			<lable>'יך'</label>
				<input type="radio" id="sufixSurface_j" name="sufixSurface" value="j"/>
			<lable>'יו'</label>
				<input type="radio" id="sufixSurface_k" name="sufixSurface" value="k"/>
			<lable>'יה'</label>
				<input type="radio" id="sufixSurface_l" name="sufixSurface" value="l"/>
			<lable>'ינו'</label>
				<input type="radio" id="sufixSurface_m" name="sufixSurface" value="m"/>
			<lable>'יכם'</label>
				<input type="radio" id="sufixSurface_n" name="sufixSurface" value="n"/>
			<lable>'יכן'</label>
				<input type="radio" id="sufixSurface_o" name="sufixSurface" value="o"/>
			<lable>'יהם'</label>
				<input type="radio" id="sufixSurface_p" name="sufixSurface" value="p"/>
			<lable>'יהן'</label>
				<input type="radio" id="sufixSurface_q" name="sufixSurface" value="q"/> 
		<br/><label><b>function </b></label><br/>
			<lable>unspecified</label>
				<input type="radio" id="sufixFunction_N" name="sufixFunction" value="N"checked/>
			<lable>possessive</label>
				<input type="radio" id="sufixFunction_a" name="sufixFunction" value="a"/>
			<lable>accusative</label>
				<input type="radio" id="sufixFunction_b" name="sufixFunction" value="b"/>
			<lable>nominative</label>
				<input type="radio" id="sufixFunction_c" name="sufixFunction" value="c"/>
			<lable>accusative or nominative</label>
				<input type="radio" id="sufixFunction_d" name="sufixFunction" value="d"/>
			<lable>pronomial</label>
				<input type="radio" id="sufixFunction_e" name="sufixFunction" value="e"/>
		<br/><label><b>person: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="sufixPerson_N" name="sufixPerson" value="N"checked/>	
			<lable>first</label>
				<input type="radio" id="sufixPerson_a" name="sufixPerson" value="a"/> 
			<lable>second</label>
				<input type="radio" id="sufixPerson_b" name="sufixPerson" value="b"/>
			<lable>third</label>
				<input type="radio" id="sufixPerson_c" name="sufixPerson" value="c"/>
			<lable>any</label>
				<input type="radio" id="sufixPerson_d" name="sufixPerson" value="d"/>
		<br/><label><b>gender: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="sufixGender_N" name="sufixGender" value="N"checked/>
			<lable>masculine</label>
				<input type="radio" id="sufixGender_a" name="sufixGender" value="a"/>
			<lable>feminine</label>
				<input type="radio" id="sufixGender_b" name="sufixGender" value="b"/>
			<lable>masculine and feminine</label>
				<input type="radio" id="sufixGender_c" name="sufixGender" value="c"/>
		<br/><label><b>number: </b></label><br/> 
			<lable>unspecified</label>
				<input type="radio" id="sufixNumber_N" name="sufixNumber" value="N"checked/>
			<lable>singular</label>
				<input type="radio" id="sufixNumber_a" name="sufixNumber" value="a"/> 
			<lable>plural</label>
				<input type="radio" id="sufixNumber_b" name="sufixNumber" value="b"/> 
			<lable>dual</label>
				<input type="radio" id="sufixNumber_c" name="sufixNumber" value="c"/> 
			<lable>dual and plural</label>
				<input type="radio" id="sufixNumber_d" name="sufixNumber" value="d"/> 
			<lable>singular and plural</label>
				<input type="radio" id="sufixNumber_e" name="sufixNumber" value="e"/>
	</p>
	<br/><br/>

	
</form>

<!--
	<lable>unspecified</label>
		<input type="radio" id="$$$" name="$$$" value="N"checked/>

	<lable>$$$</label>
		<input type="radio" id="$$$" name="$$$" value="$$$"/>  
-->
























