package ga.dndsip.selenium.dmTools;

import java.util.concurrent.TimeUnit;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;

public class DM_Tools_Selenium {
	
	WebDriver driver;
	
	//function used to open the browser and go to our site
	public void invokeBrowser () {
		try {
			//change the second argument in this line to where your chromedriver is to run the code or it will give an error
			System.setProperty("webdriver.chrome.driver", "C:\\Users\\Allan\\Desktop\\selinium\\chromedriver\\chromedriver.exe");
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
	//function used to navigate to the correct page to test
	public void navigateToDMToolsFromLogin() {
		try {
			driver.findElement(By.name("username")).sendKeys("Jensen");
			driver.findElement(By.name("password")).sendKeys("password");
			driver.findElement(By.id("submit")).click();
			driver.findElement(By.xpath("//a[contains(text(), 'DM Tools')]")).click();

		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	//function used to fill the turn tracker
	//takes in an parallel array of names and rolls
	//first takes in players then enemies after it hits the string enemyNames
	//test checks if current player exist, if it does then the it was filled correctly
	public void fillInTurnTracker(String[] names, String[] rolls) {
		System.out.println("Filling turn tracker");
		for (int i = 0; i < names.length; i++) {
			if (names[i].equals("enemyNames")) {
				driver.findElement(By.id("initNewTurnEnemy")).click();
			}
			else {
				driver.findElement(By.id("initNewTurnName")).clear();
				driver.findElement(By.id("initNewTurnName")).sendKeys(names[i]);
				driver.findElement(By.id("initNewTurnRoll")).clear();
				driver.findElement(By.id("initNewTurnRoll")).sendKeys(rolls[i]);
				driver.findElement(By.id("initNewTurnAdd")).click();
			}
		}
		String testResult = "fail";
		if (driver.findElements(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[1]")).size() > 0) {
			testResult = "pass";
		}
		System.out.println("Filled Turn Tracker: " + testResult + "\n");
	}
	
	//clicks next turn 3  times and checks if current player is correct
	public void clickNextTurnTest() {
		System.out.println("Clicking next turn 3 times");
		//looks at the player/enemy that we want to be the current player after 3 clicks
		String name = driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[6]/div[1]")).getAttribute("innerHTML");
		String roll = driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[6]/div[2]")).getAttribute("innerHTML");
		System.out.print("4th player/enemy is ");
		System.out.println(name + " " + roll);
		try {
			for (int i = 0; i < 3; i++ ) {
				Thread.sleep(500);
				driver.findElement(By.id("initNextTurn")).click();
			}
			//looks at the current player and checks it with the earlier string that was taken earlier
			String name1 = driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[1]")).getAttribute("innerHTML");
			String roll1 = driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[2]")).getAttribute("innerHTML");
			System.out.print("Current player/enemy is ");
			System.out.println(name1 + " " + roll1);
			String testResult = "fail";
			if ((name1.equals(name)) && (roll1.equals(roll))) {
				testResult = "pass";
			}
			System.out.println("Next Turn Test(3 clicks): " + testResult + "\n");
			//start of testing full rotation in this case 7 clicks
			System.out.println("Clicking next turn 7 times full rotation");
			for (int i = 0; i < 7; i++ ) {
				Thread.sleep(500);
				driver.findElement(By.id("initNextTurn")).click();
			}
			name1 = driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[1]")).getAttribute("innerHTML");
			roll1 = driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[2]")).getAttribute("innerHTML");
			System.out.print("Current player/enemy is ");
			System.out.println(name1 + " " + roll1);
			testResult = "fail";
			if ((name1.equals(name)) && (roll1.equals(roll))) {
				testResult = "pass";
			}
			System.out.println("Next Turn Test 7 clicks(full rotation): " + testResult + "\n");
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	
	}
	
	//clears turn tracker
	public void clearTurnTracker() {
		System.out.println("Clearing turn tracker");
		while (driver.findElements(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[1]")).size() > 0) {
			driver.findElement(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[3]")).click();
		}
		String testResult = "fail";
		if (!(driver.findElements(By.xpath("//*[@id=\"initTurnOrder\"]/div[2]/div[1]")).size() > 0)) {
			testResult = "pass";
		}
		System.out.println("Cleared Turn Tracker: " + testResult + "\n");
	}
	
	public static void main(String[] args) {
		DM_Tools_Selenium testObj = new DM_Tools_Selenium();
		//parallel arrays of names and rolls DO NOT CHANGE the input 'enemyNames'/'enemyRolls' put enemies after that string 
		//make sure they are all the same length
		String[] names = {"Joseph Rousseau", "Marion Deshoulières", "Stéphanie du Coudray", "Cécile Tremblay", "enemyNames", "goblin1", "goblin2", "goblin3"};
		String[] rolls = {"3" , "6", "15", "16", "enemyRolls", "5", "6", "17"};
		
		testObj.invokeBrowser();
		testObj.navigateToDMToolsFromLogin();
		testObj.fillInTurnTracker(names, rolls);
		testObj.clickNextTurnTest();
		testObj.clearTurnTracker();
	}
}
