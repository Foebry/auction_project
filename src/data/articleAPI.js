import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const articleAPI = createApi({
    reducerPath: "articleState",
    baseQuery: fetchBaseQuery({
        baseUrl: "https://www.wdev2.be/fs_sander/api",
    }),
    endpoints: (builder) => ({
        getArticles: builder.query({
            query: () => "/articles",
            providesTags: ["allArticles"],
        }),
        getArticleById: builder.query({
            query: (id) => `/article/${id}`,
        }),
        postArticle: builder.mutation({
            query: ({ art_id, art_name, art_img, art_cat_id }) => ({
                url: `/articles`,
                method: "POST",
                body: {
                    art_id,
                    art_name,
                    art_img,
                    art_cat_id,
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        patchArticleById: builder.mutation({
            query: (id, { art_name, art_img, art_cat_id }) => ({
                url: `/article/${id}`,
                method: "PATCH",
                body: {
                    art_name,
                    art_img,
                    art_cat_id,
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        deleteArticle: builder.mutation({
            query: (id) => `article/${id}`,
            invalidatesTags: ["allArticles"],
        }),
    }),
});

export default articleAPI;
export const {
    useGetArticlesQuery,
    useGetArticleByIdQuery,
    usePostArticleMutation,
    usePatchArticleByIdMutation,
    useDeleteArticleMutation,
} = articleAPI;
