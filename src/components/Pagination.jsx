import React from "react";
import { MdNavigateNext, MdNavigateBefore } from "react-icons/md";

const Pagination = ({
    prevPage,
    total,
    nextPage,
    start,
    end,
    page,
    setPage,
}) => {
    return (
        <div className="pagination">
            <div
                className={`pagination__navigation ${
                    !prevPage ? "hidden" : ""
                }`}
            >
                <button
                    className="pagination__navigation__button pagination__navigation__button--prev"
                    disabled={!prevPage}
                    onClick={() => setPage(page - 1)}
                >
                    <MdNavigateBefore className="icon" />
                </button>
            </div>
            <div className="pagination__info">
                Auctions {start}-{end} of {total} total
            </div>
            <div
                className={`pagination__navigation ${
                    !nextPage ? "hidden" : ""
                }`}
            >
                <button
                    className="pagination__navigation__button pagination__navigation__button--next"
                    disabled={!nextPage}
                    onClick={() => setPage(page + 1)}
                >
                    <MdNavigateNext className="icon" />
                </button>
            </div>
        </div>
    );
};

export default Pagination;
