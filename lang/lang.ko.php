<?php
$clang = new stdClass();
$clang->license = "
** 주의사항 **<br/>
1. 본 게시판은 오픈소스 라이센스 규약인 GPLv3 에 의거하여 배포됩니다.<br/>
2. 스킨 제작자 분들은 따로 연락을 주시면 스킨제작에 있어 최대한 서포트 해 드리겠습니다.<br/>
3. 게시판 및 ChibiPAINT프로그램에 관련된 오류나 버그는 제작자 개인홈이나 배포페이지를 이용해주세요.<br/>
4. 본 게시판을 이용하기 위해서는 JAVA 가 필요합니다.<br/>
JAVA를 설치하지 않은 분은<br/>
http://www.java.com/ko/download/ie_manual.jsp?locale=ko&host=www.java.com<br/>
에서 다운로드를 해 주시기 바랍니다.";
$clang->cid_empty = "게시판 ID 를 적어주세요. index.php?cid=게시판ID";
$clang->board_empty = "존재하지 않는 게시판 입니다.";
$clang->installed = "이미 설치 되어 있습니다.";
$clang->is_not_login = "로그인이 필요합니다.";
$clang->is_not_admin = "관리자만 이용이 가능합니다.";
$clang->login = "로그인";
$clang->logout = "로그아웃";
$clang->fail_login = "로그인에 실패하였습니다. <br/> 아이디/비밀번호를 확인해주세요.";
$clang->admin_type_super = "최고 관리자";
$clang->admin_type_xeboard = "XE 회원";
$clang->admin_type_board = "게시판 관리자";
$clang->board_create = "게시판 만들기";
$clang->board_management = "게시판 관리";
$clang->admin_page = "관리자 페이지";
$clang->chibi_notice = "Chibi Tool BBS 공지사항";
$clang->all_visitor = "전체 방문자 수";
$clang->today_visitor = "오늘 방문자 수";
$clang->all_picture = "전체 그림 수";
$clang->all_comment = "전체 코멘트 수";
$clang->pictures = "그림";
$clang->comments = "코멘트";
$clang->number_picture = "그림 수";
$clang->number_comment = "코멘트 수";
$clang->admin_list_cid = "게시판 ID";
$clang->admin_list_skin = "스킨";
$clang->list_board_management = "게시판 관리";
$clang->skin_management = "스킨 설정";
$clang->emoticon = "이모티콘";
$clang->statics = "통계";
$clang->reset = "초기화";
$clang->del = "삭제";
$clang->create_board = "게시판 작성";
$clang->board_id = "게시판 ID";
$clang->help_board_id = "<span class=\"text-danger\">게시판 ID는 영문소문자+숫자로 작성하여주세요. 게시판 ID의 첫글자는 영문으로 작성하여 주세요.</span>";
$clang->board_id_available = "사용 가능한 게시판 ID입니다.";
$clang->board_id_unavailable = "사용 불가능한 게시판 ID입니다.";
$clang->set_skin = "스킨 선택";
$clang->help_set_skin = "사용 하실 스킨을 선택하여 주세요.";
$clang->board_titile = "게시판 타이틀";
$clang->help_board_title = "게시판 타이틀을 입력하여 주세요. 브라우저 상단에 표시되는 제목 입니다.";
$clang->board_secret = "비밀 게시판";
$clang->help_board_secret = "비밀을 선택하면 해당 게시판은 비밀 게시판으로 변경됩니다.";
$clang->board_secret_select_yes = "비밀";
$clang->board_secret_select_no = "공개";
$clang->board_secret_password = "비밀 게시판 패스워드";
$clang->help_board_secret_password = "비밀 게시판에 접속하기 위한 패스워드를 입력하여 주세요.";
$clang->use_permission = "게시판 사용 권한";
$clang->user_permission_all = "모두";
$clang->user_permission_member_b = "게시판 멤버";
$clang->user_permission_member_cms = "XE 회원";
$clang->user_permission_admin ="관리자";
$clang->member_b_password = "게시판 멤버 패스워드";
$clang->help_member_b_password = "게시판 멤버기능 사용을 위한 멤버 페스워드를 입력하여주세요.";
$clang->pic_page = "페이지 당 표시할 그림 수";
$clang->help_pic_page = "한 페이지 당 표시할 그림 수를 적어주세요.";
$clang->pic_page_bar = "페이지 바의 페이지 수";
$clang->help_pic_page_bar = "페이지 바에 표시할 페이지 수를 적어주세요.";
$clang->pic_max_width = "그림의 최대 너비";
$clang->help_pic_max_width = "치비툴 이용시 그림의 최대 너비를 적어주세요.";
$clang->pic_max_height = "그림의 최대 높이";
$clang->help_pic_max_height = "치비툴 이용시 그림의 최대 높이를 적어주세요.";
$clang->pic_min_width = "그림의 최소 너비";
$clang->help_pic_min_width = "치비툴 이용시 그림의 최소 너비를 적어주세요.";
$clang->pic_min_height = "그림의 최소 높이";
$clang->help_pic_min_height = "치비툴 이용시 그림의 최소 높이를 적어주세요.";
$clang->pic_d_width = "그림의 기본 너비";
$clang->help_pic_d_width = "치비툴 이용시 그림의 기본 너비를 적어주세요.";
$clang->pic_d_height = "그림의 기본 높이";
$clang->help_pic_d_height = "치비툴 이용시 그림의 기본 높이를 적어주세요.";
$clang->position = "소속";
$clang->position_num = "소속 갯수";
$clang->add = "추가";
$clang->inst = "명령어";
$clang->position_img = "이미지";
$clang->help_position = "이미지는 http:// 를 포함한 주소로 적어주세요.";