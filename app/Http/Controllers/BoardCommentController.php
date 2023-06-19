<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardComment;

class BoardCommentController extends Controller
{
    public function __construct(Request $request)
    {
        // 원글ID, 원글 존재여부 체크
        $this->middleware('board.check');
    }

    /**
     * @brief 댓글 목록
     * @author 추광선
     * @param int $board_id
     * @return json
     */
    public function index(Request $request)
    {
        $return = [];

        $return = BoardComment::where('board_id', $request->board_id)->orderBy('created_at', 'desc')->get();

        return response($return);
    }

    /**
     * @brief 댓글 등록
     * @author 추광선
     * @param int $board_id 원글ID
     * @param int $user_id 회원아아디
     * @param string $write 작성자이름
     * @param string $content 댓글내용
     * @return json(고유id)
     */
    public function store(Request $request)
    {
        $return = [];

        $board = new BoardComment;
        $board->board_id = $request->board_id;
        $board->user_id = $request->user_id;
        $board->writer = $request->writer;
        $board->content = $request->content;
        if ($board->save()) {
            $return['id'] = $board->id;
        }

        return response($return);
    }

    /**
     * @brief 댓글 정보
     * @author 추광선
     * @param int $id 고유ID
     * @return json
     */
    public function show(string $id)
    {
        $return = [];

        $return = BoardComment::find($id);

        if (empty($return)) {
            return response($return, 404);
        }

        return response($return);
    }

    /**
     * @brief 댓글 수정
     * @author 추광선
     * @param int $id 고유ID
     * @param string $write 작성자이름
     * @param string $content 댓글내용
     * @return json
     */
    public function update(Request $request, string $id)
    {
        $return = [];

        $board = BoardComment::find($id);

        if (!$board) {
            return response($return, 404);
        }

        $board->writer = $request->writer;
        $board->content = $request->content;
        if ($board->save()) {
            $return['id'] = $id;
        }

        return response($return);
    }

    /**
     * @brief 댓글 삭제
     * @author 추광선
     * @param int $id 고유ID
     * @return json
     */
    public function destroy(string $id)
    {
        $return = [];

        $board = BoardComment::find($id);

        if (!$board) {
            return response($return, 404);
        }

        if ($board->delete()) {
            $return['id'] = $id;
        }

        return response($return);
    }
}
