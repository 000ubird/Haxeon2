# Haxeon2
new haxeon project  
---
### 自作ライブラリの使い方  
#### 読み込み  
---
`$this->load->library('tag');`  
#### 呼び出せるもの  
---  
* getTag($projectID); ... 返り値: プロジェクトが持つタグの配列  
view上では例として  
```  
//$data['tags']がデータにあるとする
foreach($tags as $tag){
    echo '<p>'. $tag .'</p>';
}
```  
でタグが表示できる
  
