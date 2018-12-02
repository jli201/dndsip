package char_sheet_Selenium;
import java.util.concurrent.TimeUnit;
import java.util.List;
import java.util.ArrayList;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class CharSheetSelenium {
	
	WebDriver driver;
	
	//Set this as true if you want the test data to give more detail than: "type = this, pass/fail"
	boolean verboseTests = false;
	
	//Set this as true if you only want to see tests that failed be printed to the console
	boolean onlyDisplayFailedTests = false;
	
	//make a list of characters, this is a global variable that's set in driveByPlayerCharactersToCharacterSheet
	List<WebElement> characters;

	//The index of the character page we're testing on. This is a global variable that's set in driveByPlayerCharactersToCharacterSheet
	int testSheetIndex = 0;
	
	
	//This is the account name we'll be logging onto
	String accountName = "jensen";
	
	//This funciton is used to set up the google chrome driver and navagate to dndsip.ga
	public void invokeBrowser() {
		try {
			System.setProperty("webdriver.chrome.driver", "D:\\Selenium\\chromedriver.exe");
			driver = new ChromeDriver();
			driver.manage().deleteAllCookies();
			driver.manage().window().maximize();
			driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
			driver.manage().timeouts().pageLoadTimeout(30, TimeUnit.SECONDS);
			
			driver.get("https://dndsip.ga");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	//This function is to quickly navigate the login page and get to the player character page
	public void driveByLoginToPlayerCharacters() {
		
		try {
			//Find username box and enter username
			driver.findElement(By.name("username")).sendKeys(accountName);
			
			//Find password box and enter password
			driver.findElement(By.name("password")).sendKeys("password");
			
			//Find login button and click it
			driver.findElement(By.id("submit")).click();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	//This function is to quickly navigate the player character page and get to the character sheet page
	public void driveByPlayerCharactersToCharacterSheet() {
		
		try {
			//set characters global variable
			List<WebElement> characters = driver.findElements(By.className("characterSelectButton"));

			//set testSheetIndex global variable 
			testSheetIndex = characters.size()-1;
			
			//Go to the last character sheet and click it
			characters.get(testSheetIndex).click();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//UTILITY FUNCTIONS
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//This is a simple function that adds 2 strings together
	public String add2Strings(String input, String modifier) {
		try {
			if(input == "-" || input == "-0" || input == "") {
				return input;
			}
			String sum = "";
			
			//convert everything to an int, then add them
			int tempInput = Integer.parseInt(input);
			int tempModifier = Integer.parseInt(modifier);
			int tempSum = tempInput + tempModifier;
			sum = "" + tempSum;
			
			return sum;
		} catch (NumberFormatException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	//There were a lot of instances where we needed to increment/decrement the proficiency by 1, so this is a shorthand function
	public void changeProficiency(String inputProficiency, String mod) {
		try {
			//Proficiency = CurrentProficiency + mod
			inputProficiency = add2Strings(inputProficiency, mod);
			
			//clear current proficiency
			driver.findElement(By.id("proficiency")).clear();
			
			//set new proficiency
			driver.findElement(By.id("proficiency")).sendKeys(inputProficiency);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	//Get the input proficiency of charSheet. If this element isn't set, set it to 2
	public String getInputProficiency() {
		try {
			String inputProficiency = driver.findElement(By.id("proficiency")).getAttribute("value");
			if(inputProficiency.equals("")) {
				inputProficiency = "2";
				driver.findElement(By.id("proficiency")).clear();
				driver.findElement(By.id("proficiency")).sendKeys("2");
			}
			return inputProficiency;
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	//Some pretty looking error checking, this function displays the output of tests
	public void printTestOutput(String testTitle, String result, String inputTested, String inputValue, String expectedValue) {
		try {
			
			//If we only want to see failed tests and we're given one that passed, just leave
			if(onlyDisplayFailedTests == true) {
				if(result == "pass")
					return;
			}
			
			//This is where the test printing happens. We can have simple or verbose tests
			if(verboseTests) {
				System.out.println(testTitle + ":");
				System.out.println("   inputStat = " + inputTested + ", inputValue = " + inputValue + ", expectedValue = " + expectedValue +":");
				System.out.println("   result: " + result);
			}else {
				System.out.println(testTitle + ", " + inputTested + ": " + result);
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void saveAndLeave() {
		//save the page
		driver.findElement(By.name("save")).click();
		
		//Leave character page
		driver.findElement(By.name("backToCharacters")).click();
	}
	
	//This function saves the page, backs out, and then goes back in so a function can check if the page was loaded correctly
	public void saveAndReload() {
		try {
			//save page and leave
			saveAndLeave();
			//Go back to same character sheet
			driveByPlayerCharactersToCharacterSheet();
			
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//END OF UTILITY FUNCTIONS
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CHARACTER SHEET TESTS
	// ONLY RUN THESE TESTS IF YOU'RE CURRENTLY ON THE CHARACTER SHEET
	//////////////////////////////////////////////////////////////////////////////t////////////////////////////////
	/*
	* inputStat is the stat we're focusing on for this test, inputValue is the value we're setting the stat mods to, expectedValue is the modifier we're expecting to see given the inputStat
	* This test cycles through all stats and checks all relevant skills, saves, ect. to ensure everything recieved the modifier
	*/
	public String testOneStatMod(String inputStat, String inputValue, String expectedValue) {
		
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is the modifier that we want to see get the right value
			String inputModifier = inputStat.substring(0,3) + "Mod";
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//get the value we're testing for
			testValue = driver.findElement(By.id(inputModifier)).getText();
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else 
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	
	
	public String testOneSavingThrowWithoutProficiency(String inputStat, String inputValue, String expectedValue) {
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is how we identify the proficiency checkbox for the stat we're testing
			String inputCheckBox = inputStat.substring(0,3) + "Checkbox";
			
			//A WebElement to keep track of the proficiency checkbox. Not necessary but it cleans up the code
			WebElement profCheckBox = driver.findElement(By.id(inputCheckBox));
			
			//This is the saving throw we want to test
			String inputSavingThrow = inputStat + "SavingThrow";
				
			//Uncheck the profCheckBox if it is checked
			if(profCheckBox.isSelected())
				profCheckBox.click();
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//get the value we're testing for
			testValue = driver.findElement(By.id(inputSavingThrow)).getAttribute("value");
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
		
	}
	
	public void testDriverTestOneSavingThrow(String inputStat, String inputValue, String expectedValue){
		try {
			String result = "";
			
			//When an input is empty or improper, Saving throws should be -0
			if(expectedValue == "-") {
				expectedValue = "-0";
			}
			//Test Saving throw without proficiency
				result = testOneSavingThrowWithoutProficiency(inputStat, inputValue, expectedValue);
				
				//Some pretty looking error checking
				printTestOutput("Saving Throw w/o proficiency", result, inputStat, inputValue, expectedValue);
			
			//Test Saving throw with proficiency
				result = testOneSavingThrowWithProficiency(inputStat, inputValue, expectedValue);
				
				//Some pretty looking error checking
				printTestOutput("Saving Throw w/ proficiency", result, inputStat, inputValue, expectedValue);
				
			//Test Saving throw proficiency change
				result = testOneSavingThrowProficiencyChange(inputStat, inputValue, expectedValue);
				
				//Some pretty looking error checking
				printTestOutput("Saving Throw proficiency change", result, inputStat, inputValue, expectedValue);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public String testOneSavingThrowWithProficiency(String inputStat, String inputValue, String expectedValue) {
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is how we identify the proficiency checkbox for the stat we're testing
			String inputCheckBox = inputStat.substring(0,3) + "Checkbox";
			
			//A WebElement to keep track of the proficiency checkbox. Not necessary but it cleans up the code
			WebElement profCheckBox = driver.findElement(By.id(inputCheckBox));
			
			//This is the saving throw we want to test
			String inputSavingThrow = inputStat + "SavingThrow";
			
			//Get the current value of the input box
			String inputProficiency = getInputProficiency();
				
			//Check the profCheckBox if it is unchecked
			if(!profCheckBox.isSelected())
				profCheckBox.click();
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//get testValue again, now the proficiency box is checked it should have changed
			testValue = driver.findElement(By.id(inputSavingThrow)).getAttribute("value");
			
			//hardcode the proficiency bonus into the expected value
			expectedValue = add2Strings(expectedValue, inputProficiency);
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else 
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	//This is basically "testOneSavingThrowWithProficiency" except it doesn't use the inputValue, and thus can be used without accidentaly resetting the values we're trying to test
	public String testOneSavingThrowProficiencyChangeHelper(String inputStat, String expectedValue) {
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is how we identify the proficiency checkbox for the stat we're testing
			String inputCheckBox = inputStat.substring(0,3) + "Checkbox";
			
			//A WebElement to keep track of the proficiency checkbox. Not necessary but it cleans up the code
			WebElement profCheckBox = driver.findElement(By.id(inputCheckBox));
			
			//This is the saving throw we want to test
			String inputSavingThrow = inputStat + "SavingThrow";
			
			//Get the current value of the input box
			String inputProficiency = getInputProficiency();
				
			//Check the profCheckBox if it is unchecked
			if(!profCheckBox.isSelected())
				profCheckBox.click();
			
			//get testValue again, now the proficiency box is checked it should have changed
			testValue = driver.findElement(By.id(inputSavingThrow)).getAttribute("value");
			
			//hardcode the proficiency bonus into the expected value
			expectedValue = add2Strings(expectedValue, inputProficiency);
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else 
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	public String testOneSavingThrowProficiencyChange(String inputStat, String inputValue, String expectedValue) {
		
		//Clear any field that we're going put inputs in
		driver.findElement(By.id(inputStat)).clear();
		
		//input the value we're using to test
		driver.findElement(By.id(inputStat)).sendKeys(inputValue);
		
		if(testOneSavingThrowProficiencyChangeHelper(inputStat, expectedValue) == "pass") {
			
			//get the current proficiency modifier and add 1. Then set the proficiency to this new number
				//get current proficiency modifier
				String inputProficiency = getInputProficiency();
				
				//add 1 to the proficiency
				changeProficiency(inputProficiency, "1");
				
				//click somewhere else on the page so the input refreshes
				driver.findElement(By.id(inputStat)).click();
				
				//click somewhere else on the page. This allows the page to update the new proficiency values
		
			//now that we've added 1 to the proficiency
			if(testOneSavingThrowProficiencyChangeHelper(inputStat, expectedValue) == "pass") {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "pass";
			}else {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "fail";
			}
			
		}else
			return "fail";
	}
	
	public String testOneSkillWithoutProficiency(String inputSkill, String inputValue, String expectedValue) {
		//This test value is what we hope is = to the expected value
		String testValue = "";
		
		//get the checkBox name for the skill we're testing
		String skillCheckbox = inputSkill + "Checkbox";
		
		//A WebElement to keep track of the proficiency checkbox linked to the skill. Not necessary but it cleans up the code
		WebElement profCheckBox = driver.findElement(By.id(skillCheckbox));
		
		//Uncheck the profCheckBox if it is checked
		if(profCheckBox.isSelected())
			profCheckBox.click();
		
		//get the value of the skill we're testing for
		testValue = driver.findElement(By.id(inputSkill)).getAttribute("value");
		
		//See how well we did
		if(testValue.equals(expectedValue))
			return "pass";
		else
			return "fail";
	}
	
	public String testOneSkillWithProficiency(String inputSkill, String inputValue, String expectedValue) {
		//Get the input proficiency.
		String inputProficiency = getInputProficiency();
		
		//hardcode the proficiency bonus into the expected value
		expectedValue = add2Strings(expectedValue, inputProficiency);
		
		//This test value is what we hope is = to the expected value
		String testValue = "";
		
		//get the checkBox name for the skill we're testing
		String skillCheckbox = inputSkill + "Checkbox";
		
		//A WebElement to keep track of the proficiency checkbox linked to the skill. Not necessary but it cleans up the code
		WebElement profCheckBox = driver.findElement(By.id(skillCheckbox));
		
		//Check the profCheckBox if it is unchecked
		if(!profCheckBox.isSelected())
			profCheckBox.click();
		
		//get the value of the skill we're testing for
		testValue = driver.findElement(By.id(inputSkill)).getAttribute("value");
		
		//See how well we did
		if(testValue.equals(expectedValue))
			return "pass";
		else
			return "fail";
	}
	
	public String testOneSkillProficiencyChange(String inputSkill, String inputValue, String expectedValue) {
		
		//first run the proficiency test and make sure it works
		if(testOneSkillWithProficiency(inputSkill, inputValue, expectedValue) == "pass") {
			
			//get the current proficiency modifier and add 1. Then set the proficiency to this new number
				//get current proficiency modifier
				String inputProficiency = getInputProficiency();
				
				//add 1 to the proficiency
				changeProficiency(inputProficiency, "1");
				
				//click somewhere else on the page so the input refreshes
				driver.findElement(By.id(inputSkill)).click();
				
			//now that we've added 1 to the proficiency
			if(testOneSkillWithProficiency(inputSkill, inputValue, expectedValue) == "pass") {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "pass";
			}else {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "fail";
			}
		}else {
			return "fail";
		}
	}
	
	public void testDriverTestOneSkillType(String inputStat, String inputValue, String expectedValue) {
		//Clear any field that we're going put inputs in
		driver.findElement(By.id(inputStat)).clear();
		
		//input the value we're using to test
		driver.findElement(By.id(inputStat)).sendKeys(inputValue);
		
		//Create a List that contains all skills that are associated with a particular stat
			//Get the class name we need, such as "strSkill"
			String skillType = inputStat.substring(0,3) + "Skill";
			
			//Push all skills of the same class into a list
			List<WebElement> skillsList = driver.findElements(By.className(skillType));
			
			//create a second list of strings
			List<String> skills = new ArrayList<>();
			
			//take all of the elements in the "skillsList" and push their id's into "skills"
			//"skills" is now a string list of all skills that share the same stat modifier (i.e. acrobatics, sneak, and slight of hand are all dex skills)
			for(int i = 0; i < skillsList.size(); i++)
		        skills.add(skillsList.get(i).getAttribute("id"));
			
		
		//for each skill in our skills list, we want to test to see if the modifiers and proficiency works right
		for(int i = 0; i < skills.size(); i++) {
			//test skills without proficiency
			String result = testOneSkillWithoutProficiency(skills.get(i), inputValue, expectedValue);
			//Some pretty looking error checking
			printTestOutput("Skills w/o proficiency", result, skills.get(i), inputValue, expectedValue);
			
			//test skills with proficiency
			result = testOneSkillWithProficiency(skills.get(i), inputValue, expectedValue);
			//Some pretty looking error checking
			printTestOutput("Skills w/ proficiency", result, skills.get(i), inputValue, expectedValue);
			
			//test skills when proficiency changes
			result = testOneSkillProficiencyChange(skills.get(i), inputValue, expectedValue);
				//Some pretty looking error checking
				printTestOutput("Skills test on prof change", result, skills.get(i), inputValue, expectedValue);
		}
	}
	
	
	/* 
	 * NOTE: This function is a DRIVER, which means all it does is call a bunch of functions. Each function within can be called independently!
	 * 
	 * inputValue is the value we're setting the stat mods to, expectedValue is the modifier we're expecting to see given the inputStat
	 * This test cycles through all stats and checks all relevant skills, saves, ect. to ensure everything recieved the modifier
	 */
	public void testDriverStatsAndModifiers(String[] inputValues, String[] expectedValues) {
		try {
			//We'll use this later to determine passes and fails
			String result;
			
			//This string contains the values for all the stats we want to check
			String[] inputStats = {"strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma"};
			
			//Check and make sure that there's and expected value for every input
			if(inputValues.length != expectedValues.length) {
				System.out.println("Cannot Run Test! Inputs and Outputs of unequal length!");
				return;
			}
			
			//Here we loop through all the stats, performing tests on them
			for(int i = 0; i < inputStats.length; i++) {
				
				//Here we loop through all the input values we want to test for each stat
				for(int j = 0; j < inputValues.length; j++) {
					//Modifier Test
						//The actual test
						result = testOneStatMod(inputStats[i], inputValues[j], expectedValues[j]);
						
						//Some pretty looking error checking
						printTestOutput("Modifier test", result, inputStats[i], inputValues[j], expectedValues[j]);
						
					//Saving Throw Test
						//The actual test
						testDriverTestOneSavingThrow(inputStats[i], inputValues[j], expectedValues[j]);
						
					//Skills Test
						testDriverTestOneSkillType(inputStats[i], inputValues[j], expectedValues[j]);
				}
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public String saveTestOneStat(String inputStat, String inputValue) {
		try {
			//A variable we'll need later to check loaded value vs input value
			String loadedTestValue;
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.name(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.name(inputStat)).sendKeys(inputValue);
			
			//check if data was saved
			saveAndReload();
			
			//get the value of the skill we're testing for
			loadedTestValue = driver.findElement(By.name(inputStat)).getAttribute("value");
			
			//Test if we loaded the same value we put in
			if(inputValue.equals(loadedTestValue))
				return "pass";
			else
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "fail";
		}
	}
	
	//This code is used to test text boxes like character flaws and names.
	public String saveTestOneTextBox(String textBox, String inputValue) {
		try {
			//A variable we'll need later to check loaded value vs input value
			String loadedTestValue;
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.name(textBox)).clear();
			
			//input the value we're using to test
			driver.findElement(By.name(textBox)).sendKeys(inputValue);
			
			//check if data was saved
			saveAndReload();
			
			//get the value of the skill we're testing for
			loadedTestValue = driver.findElement(By.name(textBox)).getAttribute("value");
			
			//Test if we loaded the same value we put in
			if(inputValue.equals(loadedTestValue))
				return "pass";
			else
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "fail";
		}
	}
	
	public String saveTestOneCheckBox(String checkBoxName, boolean checked) {	
		//name our checkbox something so it's easy to access
		WebElement checkBox = driver.findElement(By.id(checkBoxName));
		
		//if the checkbox isn't in the state we want it to be currently, then change it
		if(checkBox.isSelected() != checked)
			checkBox.click();
		
		//save the page and come back
		saveAndReload();
		
		//aquire our loaded checkbox value
		checkBox = driver.findElement(By.id(checkBoxName));
		
		//see if we got the result we wanted
		if(checkBox.isSelected() == checked)
			return "pass";
		else
			return "fail";
	}
	
	//This class is extreamly complicated, and is unlikely to be finished due to time constraints
	public String saveTestOneDisplayedCharacterValue(String externalDisplay, String externalOutput, String inputBox, String inputValue) {
		
		//A variable we'll need later to check loaded value vs input value
		String loadedTestValue;
		
		//Clear any field that we're going put inputs in
		driver.findElement(By.name(inputBox)).clear();
		
		//input the value we're using to test
		driver.findElement(By.name(inputBox)).sendKeys(inputValue);
		
		//check if data was saved
		saveAndLeave();
		
		//We're now on the character List page!
		
			//
		
		//get the value of the skill we're testing for
		loadedTestValue = driver.findElement(By.name(inputBox)).getAttribute("value");
		
		if(inputValue.equals(loadedTestValue))
			return "pass";
		else
			return "fail";
	}
	//This function is identical to the above one, but uses names and not ids. Unfortunately I can't find a better way to do this due to time constraints
	public String saveTestOneCheckBoxName(String checkBoxName, boolean checked) {	
		//name our checkbox something so it's easy to access
		WebElement checkBox = driver.findElement(By.name(checkBoxName));
		
		//if the checkbox isn't in the state we want it to be currently, then change it
		if(checkBox.isSelected() != checked)
			checkBox.click();
		
		//save the page and come back
		saveAndReload();
		
		//aquire our loaded checkbox value
		checkBox = driver.findElement(By.name(checkBoxName));
		
		//see if we got the result we wanted
		if(checkBox.isSelected() == checked)
			return "pass";
		else
			return "fail";
	}
	
	public void testDriverTopColumn(String[] inputValues) {
		//These elements were meant to check the values displayed, but they are unable to be used to time constraints
			String[] displayedCharacterValues = {"characterName", "class", "level", "race"};
			String[] displayedCharacterValuesNameElements = {"charName", "class", "level", "race"};
		String[] otherCharacterValues = {"playerName", "alignment", "experiencePoints"};
		String result;
		
		//We have to seperate displayed character values from the other top column values because these ones are displayed on the character list page
		for(String charValue : displayedCharacterValues) {
			for(String inputValue : inputValues) {
				result = saveTestOneTextBox(charValue, inputValue);
				printTestOutput("Displayed Top Column", result, charValue, inputValue, inputValue);
			}
		}
		for(String charValue : otherCharacterValues) {
			for(String inputValue : inputValues) {
				result = saveTestOneTextBox(charValue, inputValue);
				printTestOutput("Top Column", result, charValue, inputValue, inputValue);
			}
		}
	}
	
	public void testDriverTestStatsSaveAndLoad(String[] inputValues) {
		//We'll use this to receive pass/fail from the tests
		String result;
		
		//This string contains the values for all the stats we want to check
		String[] inputStats = {"strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma",
				"passivePerception", "ac", "initiative", "speed", "hpCurrent", "hpMax", "tempHp", 
				"hitDiceCurrent", "hitDiceMax", "firstLevelCurrent", "firstLevelMax", "secondLevelCurrent",
				"secondLevelMax", "thirdLevelCurrent", "thirdLevelMax", "fourthLevelCurrent", 
				"fourthLevelMax", "fifthLevelCurrent", "fifthLevelMax", "sixthLevelCurrent", "sixthLevelMax",
				"seventhLevelCurrent", "seventhLevelMax", "eighthLevelCurrent", "eighthLevelMax", 
				"ninthLevelCurrent", "ninthLevelMax"};
		
		//Here we loop through all the stats, performing tests on them
		for(int i = 0; i < inputStats.length; i++) {
			
			//Here we loop through all the input values we want to test for each stat
			for(int j = 0; j < inputValues.length; j++) {
				
				//Test saving/loading our stats
				result = saveTestOneStat(inputStats[i], inputValues[j]);
				//print some pretty error logging
				printTestOutput("Stat save/load test", result, inputStats[i], inputValues[j], inputValues[j]);
			}
		}
	}
	
	public void testDriverTextBox(String[] inputValues) {
		//We'll use this to receive pass/fail from the tests
		String result;
		
		//This string contains the values for all the stats we want to check
		String[] inputBoxes = {"other", "traits", "ideals", "bonds", "flaws", "featuresAndTraits"};
		
		//Here we loop through all the stats, performing tests on them
		for(int i = 0; i < inputBoxes.length; i++) {
			
			//Here we loop through all the input values we want to test for each stat
			for(int j = 0; j < inputValues.length; j++) {
				
				//Test saving/loading our stats
				result = saveTestOneTextBox(inputBoxes[i], inputValues[j]);
				//print some pretty error logging
				printTestOutput("TextBoxes save/load test", result, inputBoxes[i], inputValues[j], inputValues[j]);
			}
		}
		
	}
	
	public void testDriverCheckBoxes() {
		String result;
		//this is for testing
		boolean[] testValues = {true, false};
		//this is for printing errors
		String[] testPrinting = {"true", "false"};
		
		
		String[] checkBoxesIds = {
				"strCheckbox", "dexCheckbox", "conCheckbox", "intCheckbox", "wisCheckbox", "chaCheckbox",
				"acrobaticsCheckbox", "animalCheckbox", "arcanaCheckbox","athleticsCheckbox","deceptionCheckbox",
				"historyCheckbox","insightCheckbox","intimidationCheckbox","investigationCheckbox","medicineCheckbox",
				"natureCheckbox","perceptionCheckbox","performanceCheckbox","persuasionCheckbox","religionCheckbox",
				"sleightCheckbox","stealthCheckbox","survivalCheckbox"};
		
		String[] checkBoxesNames = {
				"inspiration", "manualEntry", "deathSuccessOne", "deathSuccessTwo", "deathSuccessThree",
				"deathFailOne", "deathFailTwo", "deathFailThree"
		};
		
		//iterate true/false for all checkboxes
		for(int i = 0; i < checkBoxesIds.length; i++) {
			for(int j = 0; j < testValues.length; j++) {
				result = saveTestOneCheckBox(checkBoxesIds[i], testValues[j]);
				printTestOutput("Checkbox test", result, checkBoxesIds[i], testPrinting[j], testPrinting[j]);
			}
		}
		
		for(int i = 0; i < checkBoxesNames.length; i++) {
			for(int j = 0; j < testValues.length; j++) {
				result = saveTestOneCheckBoxName(checkBoxesNames[i], testValues[j]);
				printTestOutput("Checkbox test", result, checkBoxesNames[i], testPrinting[j], testPrinting[j]);
			}
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// END OF CHARACTER SHEET TESTS
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public static void main(String[] args) {
		CharSheetSelenium myObj = new CharSheetSelenium();
		
		//First, set up the browser and go to dndsip.ga
		myObj.invokeBrowser();
		
		//Login to test account
		myObj.driveByLoginToPlayerCharacters();
		
		//Go to test page
		myObj.driveByPlayerCharactersToCharacterSheet();
		
		//start testing
		String[] inputValuesStatsAndModifiers = {"18", "7","-2", "11"}; //{"", "18", "7", "abc", "2.5", "-2", "11"};
		String[] expectedValuesStatsAndModifiers = {"4", "-2","-6", "0"}; //{"", "4", "-2", "-", "-4", "-6", "0"};
		String[] inputValuesTextBoxes = { "", "Short Input", 
		"Mid input: kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road"
		+"kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road"
		+"kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road"
		+"kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road kinda Middle of the road",  
		"Long input: really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input"
		+"really long input really long input really long input really long input really long input really long input",
		"231321", "#$^^%#Q#RFSDFF"
		};

		
		myObj.testDriverStatsAndModifiers(inputValuesStatsAndModifiers, expectedValuesStatsAndModifiers);
		myObj.testDriverTestStatsSaveAndLoad(inputValuesStatsAndModifiers);
		myObj.testDriverTextBox(inputValuesTextBoxes);
		myObj.testDriverTopColumn(inputValuesTextBoxes);
		myObj.testDriverCheckBoxes();
		
	}
}
