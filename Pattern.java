import java.io.*; 

class Pattern { 
  
  
    public static void main(String args[]) throws IOException 
    { 
String s="";
String a="";
for(int i=0;i<5;i++){

s+="*";
System.out.println(s);


}
for(int j=0;j<5;j++){
int length=s.length();
 s=s.substring(0, length-1);
System.out.println(s);



}
}
  
    } 

