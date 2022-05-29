import React, { useContext, useEffect, useMemo, useState } from "react";
import { MdDelete, MdModeEdit, MdAdd } from "react-icons/md";
import { AppContext } from "../../context/AppContext";
import {
    useDeleteArticleMutation,
    useGetArticlesQuery,
} from "../../data/articleAPI";
import { useGetCategoriesQuery } from "../../data/categoryAPI";
import Pagination from "../../components/Pagination";
import ConfirmationModal from "../../components/modals/messageModals/ConfirmationModal";

const Articles = () => {
    const [nameFilter, setNameFilter] = useState("");
    const [page, setPage] = useState(1);
    const [options, setOptions] = useState({ page, page_count: 20 });
    const [confirm, setConfirm] = useState(false);
    const [deleteArticle] = useDeleteArticleMutation();
    const [articleToDelete, setArticleToDelete] = useState(undefined);

    const { data, isError, isLoading } = useGetArticlesQuery(options, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    const { data: categoryData } = useGetCategoriesQuery(undefined);

    useEffect(() => {
        setOptions({ ...options, page });
    }, [page]);

    const confirmationHandler = (e) => {
        setArticleToDelete(e.target.dataset.id);
        setConfirm(true);
    };
    const onClose = () => {
        setConfirm(false);
    };
    const onPrimaryAction = async () => {
        const { error } = await deleteArticle(articleToDelete);

        if (!error) {
            setArticleToDelete(undefined);
            setConfirm(false);
        } else if (error) {
            console.log(error.data);
        }
    };
    const onSecondaryAction = () => {
        setArticleToDelete(undefined);
        setConfirm(false);
    };

    const memoData = useMemo(() => {
        return data?.articles
            ?.filter((el) =>
                el.art_name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ art_id, art_name, art_cat_id }) => {
                return (
                    <li className="list__article" key={art_id}>
                        <p>{art_name}</p>
                        <p>
                            {
                                categoryData?.filter(
                                    (el) => el.cat_id === art_cat_id
                                )[0].cat_name
                            }
                        </p>
                        <div className="list__buttons">
                            <button className="list__buttons__button">
                                <MdModeEdit />
                            </button>
                            <button
                                className="list__buttons__button"
                                onClick={confirmationHandler}
                                data-id={art_id}
                            >
                                <MdDelete className="icon" />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter, categoryData]);

    return (
        <section className="content" style={{ margin: "0 auto" }}>
            <div className="content__create">
                <button>
                    <div>
                        <MdAdd className="icon" />
                        <span>Toevoegen</span>
                    </div>
                </button>
            </div>
            <ul className="list">
                <li className="list__article">
                    <p>Naam</p>
                    <p>Categorie</p>
                    <input
                        type="text"
                        placeholder="Article Name"
                        value={nameFilter}
                        className="listFilter"
                        onChange={(e) => setNameFilter(e.target.value)}
                    />
                </li>
                {isError && <p>error..</p>}
                {isLoading && <p>loading..</p>}
                {memoData}
            </ul>
            <Pagination {...{ ...data, setPage }} />
            {confirm && (
                <ConfirmationModal
                    onClose={onClose}
                    message={`<p>You are about to delete '<span class="item">${
                        data?.articles.filter(
                            (el) => el.art_id == articleToDelete
                        )[0]?.art_name
                    }</span>'.</p><br /><p>Are you sure?</p>`}
                    type="Article"
                    onSecondaryAction={onSecondaryAction}
                    onPrimaryAction={onPrimaryAction}
                />
            )}
        </section>
    );
};

export default Articles;
