<style>

.uploadfile{
  height: 167px;
  display: flex;
  cursor: pointer;
  margin: 30px 0;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border-radius: 5px;
  border: 2px dashed #6c757d;
}
.uploadfile :where(i, p){
  color: #6c757d;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.uploadfile i{
  font-size: 50px;
}
.uploadfile p{
  margin-top: 15px;
  font-size: 16px;
}

.progress-area .row .content{
  width: 100%;
  margin-left: 45px;
}
.progress-area .details{
  display: flex;
  align-items: center;
  margin-bottom: 7px;
  justify-content: space-between;
}
.progress-area .content .progress-bar{
  height: 6px;
  width: 100%;
  margin-bottom: 4px;
  background: #fff;
  border-radius: 30px;
}
.content .progress-bar .progress{
  height: 100%;
  width: 0%;
  background: #6c757d;
  border-radius: inherit;
}
.uploaded-area{
  max-height: 90px;
  overflow-y: scroll;
}
.uploaded-area.onprogress{
  max-height: 150px;
}
.uploaded-area::-webkit-scrollbar{
  width: 0px;
}
.uploaded-area .row .content{
  display: flex;
  align-items: center;
  margin-left: 25px;
  border: 2px dashed #6c757d;
  padding: 10px 10px 10px 10px;
}
.uploaded-area .row .details{
  display: flex;
  margin-left: 15px;
  flex-direction: column;
}
.uploaded-area .row .details .size{
  color: #6c757d;
  font-size: 11px;
}
.uploaded-area i.fa-check{
  font-size: 16px;
}
</style>