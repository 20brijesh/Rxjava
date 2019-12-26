import java.util.Arrays;
class Bubblesort{

public static void main(String args[]){ 


int temp;
int arr[] = { 5,4,3,2,1 };
		int arr1[] = { 1,2,3,4,5 };

for(int i=0;i<=arr.length-1;i++)
{

for(int j=1;j<=arr.length-i;j++){
if(arr[j-1] < arr[j]){
temp=arr[j-1];
arr[j-1] = arr[j];
arr[j] = temp;
}


}
//System.out.println(Arrays.toString(arr));
}

}
}
