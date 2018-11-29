package dndtesting;

import java.util.concurrent.TimeUnit;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import com.mysql.*;
import  java.sql.Connection;		
import  java.sql.Statement;		
import  java.sql.ResultSet;		
import  java.sql.DriverManager;		
import  java.sql.SQLException;	

public class registrationTest {
	
	WebDriver driver;
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
	
	
	public void invokeBrowser() {
		try {
			System.setProperty("webdriver.chrome.driver" , "//Users//jensen//Selenium//Selenium//chromedriver");
			driver = new ChromeDriver();
			driver.manage().deleteAllCookies();
			driver.manage().window().maximize();
			driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
			driver.manage().timeouts().pageLoadTimeout(30, TimeUnit.SECONDS);
			
			driver.get("https://dndsip.ga/");
			login();
		
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

	public static void main(String[] args) {
		registrationTest myObj = new registrationTest();
		myObj.invokeBrowser();

	}

}
