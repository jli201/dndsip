package dndtesting;

import java.util.concurrent.TimeUnit;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import com.mysql.*;
import  java.sql.Connection;		
import  java.sql.Statement;		
import  java.sql.ResultSet;		
import  java.sql.DriverManager;		
import  java.sql.SQLException;	

public class registrationTest {
	
	WebDriver driver;
	
//Failed attempt at trying to connect mysql database with JDBC	
//	Connection connection = null; 
	
//	
//	public void connectToDB() {
//		try {
//			//Register the Drive
//			Class.forName("com.mysql.jdbc.Driver"); 
//			//Make the connection
//			Connection connection=DriverManager.getConnection("jdbc:mysql://198.211.107.179/dndsip","root","CMPS115rjullig");
//    			
//			if(connection!= null) {
//				System.out.print("Connected to the database");
//			}
//			
//		}
//		catch(SQLException |ClassNotFoundException e) {
//			System.out.println("Error while connecting to database: " + e);
//			e.printStackTrace();
//		}
//		finally {
//			if(connection != null) {
//				try {
//					connection.close();
//				}
//				catch(SQLException e) {
//					System.out.println("Failed to close connection: " + e);
//					e.printStackTrace();
//					
//				}
//			}
//		}
//	}
	
	boolean retVal;
	String notMatchingPassword = "Passwords do not match. Please try again.";
	String passwordTooShort = "Password must be between 6 and 30 characters.";
	String usernameTooShort = "Username must be between 6 and 30 characters.";
	String createdAccountText = "New account registered. Login below.";
	
	
	public void invokeBrowser() {
		try {
			System.setProperty("webdriver.chrome.driver" , "//Users//jensen//Selenium//Selenium//chromedriver");
			driver = new ChromeDriver();
			driver.manage().deleteAllCookies();
			driver.manage().window().maximize();
			driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
			driver.manage().timeouts().pageLoadTimeout(30, TimeUnit.SECONDS);
			driver.get("https://dndsip.ga/");
		
		} catch (Exception e) {
			e.printStackTrace();
			
		}
	}
	
	public void login() {
		driver.findElement(By.name("username")).sendKeys("jensen");
		driver.findElement(By.name("password")).sendKeys("password");
//		driver.findElement(By.id("submit")).click();
//		driver.findElement(By.xpath("/html/body/div[4]/div/form/button")).click();
//		driver.findElement(By.name("featuresAndTraits")).sendKeys("\nTesting with Selenium!");
//		driver.findElement(By.name("save")).click();
//		
	}
	
	public void signUp() {
		try {
			
			//diff passwords for confirm
			driver.findElement(By.id("register")).click();
			driver.findElement(By.name("username")).sendKeys("tester1");
			driver.findElement(By.name("password")).sendKeys("tester1pw");
			driver.findElement(By.name("confirmPassword")).sendKeys("tester1Wrongpw");
			driver.findElement(By.id("registerButton")).click();
			
			WebElement diffPasswords = driver.findElement(By.id("errorText"));
			String  diffPasswordsText = diffPasswords.getText();
			
			retVal = notMatchingPassword.equals( diffPasswordsText );
			if (retVal == true ) {
				System.out.println("Passwords Do Not Match Test: PASS");
			}
			else {
				System.out.println("Passwords Do Not Match Test: FAIL");
			}
			
			//password is too short
			driver.findElement(By.name("username")).sendKeys("tester1");
			driver.findElement(By.name("password")).sendKeys("123");
			driver.findElement(By.name("confirmPassword")).sendKeys("123");
			driver.findElement(By.id("registerButton")).click();
			
			WebElement shortPassword = driver.findElement(By.id("errorText"));
			String  shortPasswordText = shortPassword.getText();
			
			retVal = passwordTooShort.equals( shortPasswordText );
			if (retVal == true ) {
				System.out.println("Password Too Short Test: PASS");
			}
			else {
				System.out.println("Password Too Short Test: FAIL");
			}
			
			//username is too short
			driver.findElement(By.name("username")).sendKeys("test");
			driver.findElement(By.name("password")).sendKeys("123456");
			driver.findElement(By.name("confirmPassword")).sendKeys("123456");
			driver.findElement(By.id("registerButton")).click();
			
			WebElement shortUserName = driver.findElement(By.id("errorText"));
			String  shortUserNameText = shortUserName.getText();
			
			retVal = usernameTooShort.equals( shortUserNameText );
			if (retVal == true ) {
				System.out.println("Username Too Short Test: PASS");
			}
			else {
				System.out.println("Username Too Short Test: FAIL");
			}
			
			
			//successful account creation
			//NOTE: must change username value to something else after consecutive runs
			//bc there is no tear down for mysql database.
			driver.findElement(By.name("username")).sendKeys("tester5");
			driver.findElement(By.name("password")).sendKeys("123456");
			driver.findElement(By.name("confirmPassword")).sendKeys("123456");
			driver.findElement(By.id("registerButton")).click();
			
			
			String successCreate = driver.findElement(By.xpath("//*[@id=\"login\"]/p[2]")).getText();
			retVal = createdAccountText.equals( successCreate );
			
			if (retVal == true ) {
				System.out.println("Successful Acount Registration Test: PASS");
			}
			else {
				System.out.println("Successful Acount Registration Test: FAIL");
			}
			
			
			
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	

	public static void main(String[] args) {
		registrationTest myObj = new registrationTest();
		myObj.invokeBrowser();
		myObj.signUp();

	}

}
