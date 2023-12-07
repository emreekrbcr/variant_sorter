# Natural Based Variant Sorter But It Also Sorts Mixed Order Size Variant Like S, M, L, XL ;)

- Veritabanından gelebilecek karışık varyantları olması gerektiği gibi bir sıraya sokar. 
- Ayakkabı numaraları gibi numerik değerleri sıralı bir şekilde en sol tarafa; S,M,L,XL gibi beden bilgilerini sıralı bir şekilde orta tarafa; 
- Geri kalan tüm string ifadeleri natural comparison yaparak sıralı bir şekilde en sağ tarafa koyar. 
- En sol, orta, en sağ hizalamaları veritabanından gelebilecek karışık yani düzensiz varyantları da bir düzene koymak içindir. 
- Gelen varyantların ['7xl', 'l', 'XXXL', 'M', 'S', 'XL', 'XXS', 10, 'XXXS', '12', '20x120', '10x120', '30x120', '100x120', '45', '43'] gibi olduğunu düşünürsek bunu bile bir düzene sokacaktır.

- It arranges mixed variants from the database into the correct order.
- Numeric values such as shoe sizes are sorted to the left in ascending order; size information like S, M, L, XL is sorted in the middle;
- All other string expressions are sorted to the right using **natural comparison**.
- The alignment of left, middle, and right is designed to bring order to potentially chaotic variants that may come from the database.
- Assuming the incoming variants are like ['7xl', 'l', 'XXXL', 'M', 'S', 'XL', 'XXS', 10, 'XXXS', '12', '20x120', '10x120', '30x120', '100x120', '45', '43'], it will even organize them into a coherent order.

- The program output for the example mentioned above:
```
Array
(
    [0] => 10
    [1] => 12
    [2] => 43
    [3] => 45
    [4] => XXXS
    [5] => XXS
    [6] => S
    [7] => M
    [8] => l
    [9] => XL
    [10] => XXXL
    [11] => 7xl
    [12] => 10x120
    [13] => 20x120
    [14] => 30x120
    [15] => 100x120
)
```
